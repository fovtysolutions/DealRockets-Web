<?php

namespace App\Utils;

use App\Models\Admin;
use App\Models\BusinessSetting;
use App\Models\Chatting;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\CV;
use App\Models\TableJobProfile;
use App\Models\Seller;
use Illuminate\Support\Facades\Log;
use App\Models\Membership;
use App\Models\Leads;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Country;
use App\Models\Category;
use App\Models\ChatsOther;
use App\Models\City;
use App\Models\MembershipTier;
use App\Models\State;
use App\Utils\CategoryManager;
use Error;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\B;
use Illuminate\Support\Str;

class ChatManager
{
    public static function getProductsFooter()
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting()->take(10);

        $categories->load(['products' => function ($query) {
            $query->orderBy('views', 'desc')->limit(5);
        }]);

        $footer_prods = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'products' => $category->products,
            ];
        });

        return $footer_prods;
    }

    // Cache sellers to avoid multiple DB calls per request
    protected static $sellerCache = [];

    // Cache users with memberships
    protected static $userMembershipCache = [];

    // Get unread messages count for current customer user
    public static function unread_messages()
    {
        $userId = auth('customer')->id();
        $count = Chatting::where('user_id', $userId)
            ->where('seen_by_customer', 0)
            ->count();

        return $count > 9 ? '9+' : (string) $count;
    }

    // Mark all unread messages as read for current customer
    public static function read_message()
    {
        Chatting::where('user_id', auth('customer')->id())
            ->where('seen_by_customer', 0)
            ->update(['seen_by_customer' => 1]);
    }

    // Decode JSON message to comma separated string
    public static function decoder($message)
    {
        $decoded = json_decode($message, true);
        return is_array($decoded) ? implode(',', $decoded) : '';
    }

    // Check if the date in $message is within 31 days
    public static function daysexpiry($message)
    {
        return Carbon::now()->diffInDays(Carbon::parse($message), false) <= 31 ? 1 : 0;
    }

    // Get job applicant details based on method (cv or form)
    public static function getjobapplierdetails($user_id, $method)
    {
        if ($method === 'cv') {
            return [[
                'userdata' => User::find($user_id),
                'jb' => CV::firstWhere('user_id', $user_id)
            ]];
        }

        if ($method === 'form') {
            $profile = TableJobProfile::firstWhere('user_id', $user_id);
            return [[
                'userdata' => $profile,
                'jb' => $profile
            ]];
        }

        return 0;
    }

    // Get user details less info
    public static function getjobapplierdetailsless($user_id)
    {
        return User::find($user_id);
    }

    // Get seller or stock name by ID, batch caching to avoid N+1
    public static function getsellername($id)
    {
        if ($id === 'admin') return 'admin';

        if (isset(self::$sellerCache[$id])) {
            return self::$sellerCache[$id];
        }

        $seller = Seller::find($id);
        $name = $seller ? trim("{$seller->f_name} {$seller->l_name}") : 'Admin';

        self::$sellerCache[$id] = $name;
        return $name;
    }

    // Alias for getsellername (to avoid duplication)
    public static function getstockname($id)
    {
        return self::getsellername($id);
    }

    // Batch fetch seller names for multiple IDs (avoiding N+1)
    public static function getSellersNames(array $ids): array
    {
        $result = [];
        $toFetch = [];

        foreach ($ids as $id) {
            if ($id === 'admin') {
                $result[$id] = 'admin';
            } elseif (isset(self::$sellerCache[$id])) {
                $result[$id] = self::$sellerCache[$id];
            } else {
                $toFetch[] = $id;
            }
        }

        if (!empty($toFetch)) {
            $sellers = Seller::whereIn('id', $toFetch)->get()->keyBy('id');
            foreach ($toFetch as $id) {
                $name = isset($sellers[$id]) ? trim("{$sellers[$id]->f_name} {$sellers[$id]->l_name}") : 'Admin';
                self::$sellerCache[$id] = $name;
                $result[$id] = $name;
            }
        }

        return $result;
    }

    // Get membership status for a single user
    public static function getMembershipStatusCustomer($id)
    {
        if (!$id) return ['error' => 'Invalid ID'];

        $membershipService = new \App\Services\MembershipService();
        return $membershipService->getMembershipStatus($id, 'customer');
    }

    // Get detailed membership info using new service (alternative to membershipChecker)
    public static function getMembershipDetails()
    {
        $userId = auth('customer')->id();
        if (!$userId) {
            return ['status' => 'error', 'message' => 'Not authenticated'];
        }

        $membershipService = new \App\Services\MembershipService();
        $status = $membershipService->getMembershipStatus($userId, 'customer');

        if ($status['status'] === 'none') {
            return ['status' => 'error', 'message' => 'No membership found'];
        }

        return [
            'status' => 'success',
            'membership' => $status['membership'],
            'tier' => $status['tier'],
            'expires_at' => $status['expires_at'],
            'days_remaining' => $status['days_remaining'],
            'message' => $status['message']
        ];
    }

    // Batch fetch membership status for multiple users (avoiding N+1)
    public static function getMembershipStatusCustomers(array $userIds): array
    {
        $result = [];

        // Load users and memberships eagerly
        $users = User::whereIn('id', $userIds)->get();
        $users->load('membership'); // Make sure User model has membership relation defined

        foreach ($users as $user) {
            $membership = $user->membership;
            if (!$membership) {
                $result[$user->id] = ['error' => 'Membership not found'];
                continue;
            }
            $result[$user->id] = match ($membership->membership_status) {
                'active' => ['status' => 'active', 'message' => 'You have Already Upgraded'],
                'inactive' => ['status' => 'inactive', 'message' => 'Your Plan is being Upgraded'],
                'suspended' => ['status' => 'suspended', 'message' => 'Your Plan is Suspended'],
                'expired' => ['status' => 'expired', 'message' => 'Your Plan is Expired'],
                default => ['status' => 'unknown', 'message' => 'Invalid Plan! Contact Admin'],
            };
        }

        return $result;
    }

    public static function getUserDataChat($userId, $userRole)
    {
        switch ($userRole) {
            case 'customer':
                $user = User::find($userId);
                return [
                    'name' => $user?->name ?? 'N/A',
                ];

            case 'seller':
                $seller = Seller::find($userId);
                return [
                    'name' => $seller ? trim($seller->f_name . ' ' . $seller->l_name) : 'N/A',
                ];

            case 'admin':
                $admin = Admin::find($userId);
                return [
                    'name' => $admin?->name ?? 'N/A',
                ];

            default:
                return ['name' => 'N/A'];
        }
    }

    // Detect authenticated user role and ID
    public static function getRoleDetail()
    {
        foreach (['customer', 'seller', 'admin'] as $guard) {
            if (auth($guard)->check()) {
                return [
                    'role' => $guard,
                    'user_id' => auth($guard)->user()->id,
                ];
            }
        }

        return ['role' => 'guest', 'user_id' => null];
    }

    protected static $businessSettingsCache = [];
    protected static $categoryCache = [];
    protected static $countryCache = [];
    protected static $stateCache = [];
    protected static $cityCache = [];
    protected static $userCache = [];
    protected static $productCache = [];
    protected static $supplierCache = [];

    // Get buyer and seller leads respecting limits from business settings
    public static function Leads()
    {
        $targetCount = 30;

        // Limits from settings
        $buyerLimit = self::getBusinessSettingLimit('buyer', 10);
        $sellerLimit = self::getBusinessSettingLimit('seller', 10);

        // Fetch initial leads
        $buyerLeads = Leads::select('id', 'posted_date', 'name', 'country')
            ->where('type', 'buyer')
            ->limit($buyerLimit)
            ->get();

        $sellerLeadsAdmin = Leads::select('id', 'posted_date', 'name', 'country')
            ->where('type', 'seller')
            ->where('role', 'admin')
            ->limit($sellerLimit)
            ->get();

        $sellerLeadsSeller = Leads::select('id', 'posted_date', 'name', 'country')
            ->where('type', 'seller')
            ->where('role', 'seller')
            ->where('active', 1)
            ->get();

        $finalBuyerLeads = self::repeatCollectionToCount($buyerLeads, $targetCount);
        $mergedSellers = $sellerLeadsAdmin->merge($sellerLeadsSeller);
        $finalSellerLeads = self::repeatCollectionToCount($mergedSellers, $targetCount);

        return [
            'buyer' => $finalBuyerLeads,
            'seller' => $finalSellerLeads,
        ];
    }

    private static function repeatCollectionToCount($collection, $targetCount)
    {
        $result = collect();
        $original = $collection->values(); // reset keys
        $index = 0;

        if ($original->isEmpty()) {
            return $result; // return empty if no data to repeat
        }

        while ($result->count() < $targetCount) {
            $result->push($original[$index % $original->count()]);
            $index++;
        }

        return $result;
    }

    // Get top suppliers limited by business setting
    public static function Suppliers()
    {
        $limit = self::getBusinessSettingLimit('topsupplier', 6);
        if (!isset(self::$supplierCache[$limit])) {
            self::$supplierCache[$limit] = Supplier::limit($limit)->get();
        }
        return self::$supplierCache[$limit];
    }

    // Increase views count for a product by id
    public static function IncreaseProductView($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return ['Error', 'Product not found'];
        }

        $product->increment('views');
        return ['Success', 'Views Added Successfully'];
    }

    // Get trending products based on views and business settings limit
    public static function GetTrendingProducts()
    {
        $limit = self::getBusinessSettingLimit('trendingproducts', 12);
        return Product::orderByDesc('views')->limit($limit)->get();
    }

    // Helper to fetch limit from business settings JSON safely
    protected static function getBusinessSettingLimit(string $type, int $default): int
    {
        if (isset(self::$businessSettingsCache[$type])) {
            return self::$businessSettingsCache[$type];
        }

        $jsonValue = BusinessSetting::select('value')
            ->where('type', $type)
            ->value('value');

        $decoded = json_decode($jsonValue, true);
        $limit = $decoded['limit'] ?? $default;

        self::$businessSettingsCache[$type] = (int)$limit;

        return (int)$limit;
    }

    // Category name by ID with simple caching
    public static function getCategoryName($categoryId)
    {
        if (!$categoryId) return null;

        if (!isset(self::$categoryCache[$categoryId])) {
            $category = Category::find($categoryId);
            self::$categoryCache[$categoryId] = $category ? $category->name : null;
        }

        return self::$categoryCache[$categoryId];
    }

    // Country details by ID with validation and caching
    public static function getCountryDetails($countryId)
    {
        if (!is_numeric($countryId)) {
            return [
                'status' => 400,
                'message' => 'Invalid country ID',
                'countryName' => null,
                'countryISO2' => null,
            ];
        }

        $countryId = (int)$countryId;
        if (!isset(self::$countryCache[$countryId])) {
            $country = Country::find($countryId);
            if ($country) {
                self::$countryCache[$countryId] = [
                    'status' => 200,
                    'countryName' => $country->name,
                    'countryISO2' => $country->iso2,
                ];
            } else {
                self::$countryCache[$countryId] = [
                    'status' => 404,
                    'message' => 'Country not found',
                    'countryName' => null,
                    'countryISO2' => null,
                ];
            }
        }

        return self::$countryCache[$countryId];
    }

    // State name by ID with caching
    public static function getStateName($id)
    {
        if (!$id) return null;

        if (!isset(self::$stateCache[$id])) {
            $state = State::find($id);
            self::$stateCache[$id] = $state ? $state->name : null;
        }

        return self::$stateCache[$id];
    }

    // City name by ID with caching
    public static function getCityName($id)
    {
        if (!$id) return null;

        if (!isset(self::$cityCache[$id])) {
            $city = City::find($id);
            self::$cityCache[$id] = $city ? $city->name : null;
        }

        return self::$cityCache[$id];
    }

    // Industry details with validation
    public static function getIndustryDetails($id)
    {
        if (!is_numeric($id)) {
            return ['status' => 400, 'message' => 'Invalid industry ID', 'name' => null];
        }

        $id = (int)$id;
        if (!isset(self::$categoryCache[$id])) {
            $industry = Category::find($id);
            if ($industry) {
                self::$categoryCache[$id] = ['status' => 200, 'name' => $industry->name];
            } else {
                self::$categoryCache[$id] = ['status' => 404, 'message' => 'Industry not found', 'name' => null];
            }
        }

        return self::$categoryCache[$id];
    }

    // Get username by user ID with caching
    public static function fetchusername($id)
    {
        if (!$id) return null;

        if (!isset(self::$userCache[$id])) {
            $user = User::find($id);
            self::$userCache[$id] = $user ? $user->name : null;
        }

        return self::$userCache[$id];
    }

    // Get product thumbnail by product ID with caching
    public static function getProductImage($id)
    {
        if (!$id) return null;

        if (!isset(self::$productCache[$id])) {
            $product = Product::find($id);
            self::$productCache[$id] = $product ? $product->thumbnail : null;
        }

        return self::$productCache[$id];
    }

    // Get user image by user ID with caching
    public static function fetchImage($id)
    {
        if (!$id) return null;

        if (!isset(self::$userCache[$id])) {
            $user = User::find($id);
            self::$userCache[$id] = $user ? $user->image : null;
        }

        return self::$userCache[$id];
    }

    // Load an image resource from file path (gif, jpeg, png, bmp)
    private static function imageCreateFromAny($filepath)
    {
        if (!file_exists($filepath)) {
            return false;
        }

        $type = @exif_imagetype($filepath);

        $allowedTypes = [
            IMAGETYPE_GIF,
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
            IMAGETYPE_BMP
        ];

        if (!in_array($type, $allowedTypes)) {
            return false;
        }

        return match ($type) {
            IMAGETYPE_GIF => imageCreateFromGif($filepath),
            IMAGETYPE_JPEG => imageCreateFromJpeg($filepath),
            IMAGETYPE_PNG => imageCreateFromPng($filepath),
            IMAGETYPE_BMP => imageCreateFromBmp($filepath),
            default => false,
        };
    }

    // Get hex color value at (x, y) on given image path
    public static function getImageColorAt($image, $x, $y)
    {
        try {
            $imagePath = public_path($image);
            $imageResource = self::imageCreateFromAny($imagePath);

            if (!$imageResource) {
                throw new Exception("Unable to load or process image: $imagePath");
            }

            $color = imagecolorat($imageResource, $x, $y);

            if ($color === false) {
                throw new Exception("Failed to get color at ($x, $y) from image: $imagePath");
            }

            return strtoupper(dechex($color));
        } catch (Exception $e) {
            Log::error('Image color fetch error', [
                'image' => $image,
                'x' => $x,
                'y' => $y,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    // Convert hex color string to RGB array
    private static function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

    // Calculate luminance for given RGB color
    private static function luminance(array $rgb)
    {
        $normalize = function ($value) {
            $value /= 255;
            return ($value <= 0.03928) ? $value / 12.92 : pow(($value + 0.055) / 1.055, 2.4);
        };

        $r = $normalize($rgb['r']);
        $g = $normalize($rgb['g']);
        $b = $normalize($rgb['b']);
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    public static function getTextColorBasedOnBackground($hex)
    {
        $rgb = self::hexToRgb($hex);
        $lum = self::luminance($rgb);
        // If luminance is high, return black text; else white text
        return $lum > 0.5 ? '#000000' : '#FFFFFF';
    }

    public static function getProductName($id)
    {
        $product = Product::find($id);
        return $product ? $product->name : "Select A Product";
    }

    public static function sendNotification(array $data): bool
    {
        try {
            ChatsOther::create([
                'id'             => Str::uuid(),
                'category'       => 'notification',
                'sender_id'      => $data['sender_id'],
                'receiver_id'    => $data['receiver_id'],
                'receiver_type'  => $data['receiver_type'],
                'type'           => $data['type'] ?? null,
                'stocksell_id'   => $data['stocksell_id'] ?? null,
                'leads_id'       => $data['leads_id'] ?? null,
                'suppliers_id'   => $data['suppliers_id'] ?? null,
                'product_id'     => $data['product_id'] ?? null,
                'product_qty'    => $data['product_qty'] ?? null,
                'title'          => $data['title'] ?? null,
                'message'        => $data['message'] ?? null,
                'action_url'     => $data['action_url'] ?? null,
                'priority'       => $data['priority'] ?? 'normal',
                'is_read'        => false,
                'read_at'        => null,
                'chat_initiator' => $data['chat_initiator'] ?? null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send notification: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get grouped messages by sender for a user role and type
     * 
     * @param array|object $user_data ['user_id' => int, 'role' => string]
     * @param string $type
     * @param string $sender_type
     * @return \Illuminate\Support\Collection
     * @throws \Exception If validation fails
     */
    public static function getMessagersName($user_data, $type, $sender_type)
    {
        // Validate input
        $validated = Validator::make((array) $user_data, [
            'user_id' => 'required|integer',
            'role' => 'required|string|in:customer,seller,admin',
        ]);

        if ($validated->fails()) {
            throw new \Exception($validated->errors()->first());
        }

        // Fetch messages for receiver matching user role and id
        $messages = ChatsOther::where('receiver_type', $user_data['role'])
            ->where('receiver_id', $user_data['user_id'])
            ->where('type', $type)
            ->where('sender_type', $sender_type)
            ->get();

        // Group messages by sender_id
        $groupedMessages = $messages->groupBy('sender_id');

        // Add unread messages count and average open status per sender group
        foreach ($groupedMessages as $sender_id => $messageGroup) {
            $unreadMessages = $messageGroup->where('is_read', 0)->count();
            // Use collection property (cannot assign array keys directly on Collection)
            $groupedMessages[$sender_id] = $messageGroup;
            $groupedMessages[$sender_id]->unread_messages = $unreadMessages;

            $openstatus = self::getavgopenstatus($type, $sender_id, $messageGroup->first()->sender_type);
            $groupedMessages[$sender_id]->openstatus = $openstatus;
        }

        return $groupedMessages;
    }

    /**
     * Get chat messages between two users for a certain type
     * 
     * @param array $sender_data ['user_id' => int, 'role' => string]
     * @param array $receiver_data ['user_id' => int, 'role' => string]
     * @param string $type
     * @return \Illuminate\Support\Collection
     */
    public static function getchats($other_user_id, $other_user_type, $type, $listing_id)
    {
        $current_user = self::getRoleDetail();
        $userId = $current_user['user_id'];
        $userRole = $current_user['role'];

        $query = ChatsOther::query()->where('type', $type);

        // Match listing type with corresponding column
        switch ($type) {
            case 'products':
                $query->where('product_id', $listing_id);
                break;
            case 'stocksell':
                $query->where('stocksell_id', $listing_id);
                break;
            case 'buyleads':
            case 'sellleads':
                $query->where('leads_id', $listing_id);
                break;
            case 'dealassist':
            case 'reachout':
                // For dealassist and reachout, use chat_id as the grouping identifier
                $query->where('chat_id', $listing_id);
                break;
            default:
                return [];
        }

        // Order by sent time ascending
        $messages = $query->orderBy('sent_at', 'asc')->get();

        if ($messages->isEmpty()) return [];

        // Collect sender/receiver info once
        $userCache = [];

        $finalChat = $messages->map(function ($msg) use ($userId, $userRole, &$userCache) {
            // Determine if this message was sent by current user
            $isSelf = $msg->sender_id == $userId && $msg->sender_type == $userRole;

            // Mark as read if received by current user
            if (!$isSelf && !$msg->is_read) {
                $msg->is_read = 1;
                $msg->read_at = now();
                $msg->save();
            }

            // Cache user names to avoid repetitive DB hits
            $senderKey = $msg->sender_type . '_' . $msg->sender_id;
            if (!isset($userCache[$senderKey])) {
                $userCache[$senderKey] = self::getUserDataChat($msg->sender_id, $msg->sender_type);
            }

            return [
                'id' => $msg->id,
                'chat_id' => $msg->chat_id,
                'message' => $msg->message,
                'sender_id' => $msg->sender_id,
                'sender_type' => $msg->sender_type,
                'sender_name' => $userCache[$senderKey]['name'] ?? 'N/A',
                'receiver_id' => $msg->receiver_id,
                'receiver_type' => $msg->receiver_type,
                'sent_at' => $msg->sent_at,
                'is_read' => $msg->is_read,
                'flag' => $isSelf ? 'self' : 'other',
                'title' => $msg->title,
                'action_url' => $msg->action_url,
                'priority' => $msg->priority,
            ];
        });

        return $finalChat->toArray();
    }

    /**
     * Calculate average 'openstatus' value for chats from sender
     * 
     * @param string $type
     * @param int $sender_id
     * @param string $sender_type
     * @return float|null
     */
    public static function getavgopenstatus($type, $sender_id, $sender_type)
    {
        try {
            $userChatData = ChatsOther::where('type', $type)
                ->where('sender_id', $sender_id)
                ->where('sender_type', $sender_type)
                ->get();

            return $userChatData->avg('openstatus');
        } catch (Exception $e) {
            Log::error('Get Avg Open Status Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Check if current user is supplier
     * 
     * @return bool
     */
    public static function checkifsupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        if (empty($user_data['user_id'])) {
            return false;
        }
        $seller = Seller::find($user_data['user_id']);
        return $seller && $seller->vendor_type === 'supplier';
    }

    /**
     * Check if current user is confirmed supplier
     * 
     * @return bool
     */
    public static function checkconfirmsupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        if (empty($user_data['user_id'])) {
            return false;
        }
        $seller = Seller::find($user_data['user_id']);
        return $seller && $seller->suppliers_confirm_status == 1;
    }


    public static function checkStatusSupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        if (empty($user_data['user_id'])) {
            Log::info("User ID missing in role detail, returning 2");
            return 2;
        }

        $seller = Seller::find($user_data['user_id']);
        if (!$seller) {
            Log::info("Seller not found, returning 2");
            return 2;
        }

        if ($seller->vendor_type === 'supplier') {
            $supplierStatus = $seller->suppliers_confirm_status;
            Log::info("Returned supplier status: $supplierStatus");
            return $supplierStatus == 1 ? 1 : 0;
        }

        Log::info("Returned vendor status: 1");
        return 1;
    }

    public static function RedirectSupplierDetails()
    {
        $supplierStatus = self::checkStatusSupplier();

        switch ($supplierStatus) {
            case 0:
                Log::info("Redirecting to update supplier status");
                return ['route' => 'vendor.supplier.status.update'];
            case 1:
                Log::info("Redirecting to vendor dashboard");
                return ['route' => 'vendor.dashboard.index'];
            default:
                Log::info("Returning error page");
                return ['route' => 'error403'];
        }
    }
    public static function getCapchaStatus()
    {
        $captchaStatus = BusinessSetting::where('type', 'recaptcha')->first();
        return $captchaStatus ? $captchaStatus->status : null;
    }


    private static function getCurrentRole()
    {
        try {
            $currentRole = self::getRoleDetail();

            if (empty($currentRole['role']) || !in_array($currentRole['role'], ['customer', 'seller'])) {
                return [
                    'error' => true,
                    'message' => 'User not logged in or invalid role.',
                ];
            }

            $userId = $currentRole['user_id'];
            $role = $currentRole['role'];

            if ($role === 'customer') {
                $user = auth('customer')->user();
                if (!$user) {
                    return [
                        'error' => true,
                        'message' => 'No user is logged in.',
                    ];
                }

                return [
                    'error' => false,
                    'userdata' => $user,
                    'role' => $user->membership,
                    'status' => $user->membership_status,
                    'user_id' => $userId,
                ];
            }

            if ($role === 'seller') {
                $seller = auth('seller')->user();
                if (!$seller) {
                    return [
                        'error' => true,
                        'message' => 'No seller is logged in.',
                    ];
                }

                return [
                    'error' => false,
                    'userdata' => $seller,
                    'role' => $seller->membership,
                    'status' => $seller->membership_status,
                    'seller_id' => $userId,
                ];
            }

            return [
                'error' => true,
                'message' => 'Role not recognized.',
            ];
        } catch (\Exception $e) {
            Log::error("getCurrentRole Exception: " . $e->getMessage());
            return [
                'error' => true,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ];
        }
    }

    private static function checkValidity($userdata)
    {
        if (!$userdata || empty($userdata->membership_id)) {
            return [
                'valid' => false,
                'message' => 'Invalid user or membership ID not set.',
            ];
        }

        $membership = Membership::find($userdata->membership_id);

        if (!$membership) {
            return [
                'valid' => false,
                'message' => 'Membership not found.',
            ];
        }

        $daysSinceCreated = now()->diffInDays($membership->created_at);

        if ($daysSinceCreated > 31) {
            $userdata->membership_status = 'expired';
            $userdata->save();

            return [
                'valid' => false,
                'message' => 'Membership has expired.',
            ];
        }

        return [
            'valid' => true,
            'message' => 'Membership is valid.',
        ];
    }

    public static function membershipChecker()
    {
        $role = self::getCurrentRole();

        if (!$role['error']) {
            $validityCheck = self::checkValidity($role['userdata']);
            if ($validityCheck['valid']) {
                return [
                    'status' => 'success',
                    'membership' => $role['role'],
                ];
            }
            return [
                'status' => 'failure',
                'message' => $validityCheck['message'],
            ];
        }

        return [
            'status' => 'failure',
            'message' => $role['message'],
        ];
    }

    private static function BuyLeadsUsedThisWeek($userId, $weeklyLimit, $leadType = 'buyer')
    {
        if (!$userId) {
            return [
                'used' => 0,
                'remaining' => 0,
            ];
        }

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $leadIds = Leads::where('type', $leadType)->pluck('id');

        $leadsUsed = ChatsOther::where('sender_id', $userId)
            ->whereIn('lead_id', $leadIds)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->distinct('lead_id') // distinct by lead_id to avoid duplicates if any
            ->count('lead_id');

        $remaining = max($weeklyLimit - $leadsUsed, 0);

        return [
            'used' => $leadsUsed,
            'remaining' => $remaining,
        ];
    }

    /**
     * Generic method to calculate leads used and remaining for given user, lead type, time period, and limit.
     *
     * @param int $userId
     * @param int $limit
     * @param string $leadType ('buyer' or 'seller')
     * @param string $timePeriod ('week' or 'month')
     * @return array ['used' => int, 'remaining' => int]
     */
    private static function LeadsUsed($userId, $limit, $leadType, $timePeriod = 'month')
    {
        if (!$userId) {
            return [
                'used' => 0,
                'remaining' => 0
            ];
        }

        // Determine start and end of the specified time period
        $start = ($timePeriod === 'week') ? now()->startOfWeek() : now()->startOfMonth();
        $end = ($timePeriod === 'week') ? now()->endOfWeek() : now()->endOfMonth();

        // Get lead IDs of the specified type
        $leadIds = Leads::where('type', $leadType)->pluck('id');

        // Count distinct leads used by the user in the time period
        $used = ChatsOther::where('sender_id', $userId)
            ->whereIn('lead_id', $leadIds)
            ->whereBetween('created_at', [$start, $end])
            ->distinct('lead_id')
            ->count('lead_id');

        $remaining = max(0, $limit - $used);

        return [
            'used' => $used,
            'remaining' => $remaining
        ];
    }

    /**
     * Check buy leads usage limit based on user's membership tier and role.
     *
     * @return array ['status' => string, 'message' => string]
     */
    public static function checkbuyleadslimit()
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error']) {
            return [
                'status' => 'failure',
                'message' => $getRole['message'],
            ];
        }

        $checkValidity = self::checkValidity($getRole['userdata']);
        if (!$checkValidity['valid']) {
            return [
                'status' => 'failure',
                'message' => $checkValidity['message'],
            ];
        }

        $roleType = $getRole['role'] === 'customer' ? 'customer' : 'seller';

        $membershipTier = MembershipTier::where('membership_type', $roleType)
            ->where('membership_name', $getRole['role'])
            ->first();

        if (!$membershipTier) {
            return [
                'status' => 'failure',
                'message' => 'Membership tier not found.',
            ];
        }

        $membershipBenefits = json_decode($membershipTier->membership_benefits, true);
        $leadslimit = $membershipBenefits['buy_leads'] ?? 0;

        // Unlimited leads
        if ($leadslimit == -1) {
            return [
                'status' => 'success',
                'message' => 'Unlimited Leads',
            ];
        }

        // Determine if user membership is Free or Paid for limit period
        $membershipType = $getRole['userdata']->membership_type ?? 'Paid'; // Default 'Paid' if not set

        $timePeriod = ($membershipType === 'Free') ? 'week' : 'month';

        $userId = $getRole['userdata']->id ?? $getRole['userdata']->seller_id ?? null;

        $usedLeads = self::LeadsUsed(
            $userId,
            $leadslimit,
            'buyer',
            $timePeriod
        );

        if ($usedLeads['used'] >= $leadslimit) {
            return [
                'status' => 'failure',
                'message' => 'Leads Used Up. Wait for Next ' . ucfirst($timePeriod) . ' for Limit to reset.',
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Leads Remaining: ' . $usedLeads['remaining'],
        ];
    }

    /**
     * Check sell leads usage limit (similar logic as buy leads).
     * You can extend this similarly if needed.
     *
     * @param int $userId
     * @param int $limit
     * @param string $membershipType ('Free' or 'Paid')
     * @return array
     */
    public static function checkSellLeadsLimit($userId, $limit, $membershipType = 'Paid')
    {
        if (!$userId) {
            return [
                'used' => 0,
                'remaining' => 0
            ];
        }

        $timePeriod = ($membershipType === 'Free') ? 'week' : 'month';

        return self::LeadsUsed($userId, $limit, 'seller', $timePeriod);
    }

    public static function checkLeadsLimit($leadType = 'buyer', $timePeriod = 'month')
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error'] === false) {
            $checkValidity = self::checkValidity($getRole['userdata']);
            if ($checkValidity['valid'] === true) {
                // Determine user ID and membership type for query
                $userId = $getRole['user_id'] ?? $getRole['seller_id'] ?? null;
                if (!$userId) {
                    return [
                        'status' => 'failure',
                        'message' => 'User identification failed. Contact support.'
                    ];
                }

                // membership_type is 'customer' if user_id exists else 'seller'
                $membershipType = isset($getRole['user_id']) ? 'customer' : 'seller';
                $role = $getRole['role'];

                // Fetch membership benefits once
                $membershipTier = MembershipTier::where('membership_type', $membershipType)
                    ->where('membership_name', $role)
                    ->first();

                if (!$membershipTier) {
                    return ['status' => 'failure', 'message' => 'Membership tier not found.'];
                }

                $membershipDetails = json_decode($membershipTier->membership_benefits, true);

                // Unlimited leads case
                if (($membershipDetails["{$leadType}_leads"] ?? 0) == -1) {
                    return ['status' => 'success', 'message' => 'Unlimited Leads'];
                }

                $leadLimit = $membershipDetails["{$leadType}_leads"] ?? 0;

                $leadsUsed = self::LeadsUsed($userId, $leadLimit, $leadType, $timePeriod);

                if ($leadsUsed['used'] >= $leadLimit) {
                    return [
                        'status' => 'failure',
                        'message' => 'Leads Used Up. Wait for Next ' . ucfirst($timePeriod) . ' for Limit to reset.'
                    ];
                }

                return [
                    'status' => 'success',
                    'message' => "Leads Remaining: {$leadsUsed['remaining']}"
                ];
            }

            return [
                'status' => 'failure',
                'message' => $checkValidity['message']
            ];
        }

        return [
            'status' => 'failure',
            'message' => $getRole['message']
        ];
    }

    private static function CVUsed($userId, $limit, $leadType = 'seller', $timePeriod = 'month')
    {
        if (!$userId) return ['used' => 0, 'remaining' => 0];

        $start = ($timePeriod === 'week') ? now()->startOfWeek() : now()->startOfMonth();
        $end = ($timePeriod === 'week') ? now()->endOfWeek() : now()->endOfMonth();

        $leadIds = Leads::where('type', $leadType)->pluck('id');

        $used = ChatsOther::where('sender_id', $userId)
            ->whereIn('lead_id', $leadIds)
            ->whereBetween('created_at', [$start, $end])
            ->distinct('lead_id')
            ->count('lead_id');

        return [
            'used' => $used,
            'remaining' => max(0, $limit - $used)
        ];
    }

    private static function SaleOfferMade($userId, $limit, $leadType = 'seller')
    {
        if (!$userId) return ['used' => 0, 'remaining' => 0];

        $used = Leads::where([
            ['type', $leadType],
            ['added_by', $userId],
            ['role', $leadType],
            ['active', 1]
        ])->count();

        return [
            'used' => $used,
            'remaining' => max(0, $limit - $used)
        ];
    }

    public static function checkcvlimit()
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error']) {
            return ['status' => 'failure', 'message' => $getRole['message']];
        }

        $checkValidity = self::checkValidity($getRole['userdata']);
        if (!$checkValidity['valid']) {
            return ['status' => 'failure', 'message' => $checkValidity['message']];
        }

        $accessCheck = self::checkindustryjobsaccess();
        if ($accessCheck['status'] !== 'success') {
            return $accessCheck;
        }

        // Determine user type and id
        $userType = isset($getRole['user_id']) ? 'customer' : 'seller';
        $userId = $getRole[$userType . '_id'] ?? null;

        if (!$userId) {
            return ['status' => 'failure', 'message' => 'Contact Admin or Support Ticket'];
        }

        $membership = MembershipTier::where([
            ['membership_type', $userType],
            ['membership_name', $getRole['role']]
        ])->first();

        if (!$membership) {
            return ['status' => 'failure', 'message' => 'Membership tier not found.'];
        }

        $benefits = json_decode($membership->membership_benefits, true);
        $leadLimit = $benefits['no_of_cv'] ?? 0;

        if ($leadLimit == -1) {
            return ['status' => 'success', 'message' => 'Unlimited Leads'];
        }

        $extraLimit = HelperUtil::getCvTopUpValue($userId, $getRole['role']);
        $totalLimit = $leadLimit + $extraLimit;

        $timePeriod = ($getRole['role'] === 'Free') ? 'week' : 'month';

        $leadsUsed = self::CVUsed($userId, $totalLimit, 'seller', $timePeriod);

        if ($leadsUsed['used'] >= $totalLimit) {
            return ['status' => 'failure', 'message' => 'Leads Used Up. Wait for the limit to reset.'];
        }

        if ($leadsUsed['used'] >= $leadLimit && $extraLimit > 0) {
            HelperUtil::consumeCvTopUp($userId, $userType);
            return [
                'status' => 'success',
                'message' => 'Using Top-Up. Leads Remaining: ' . ($totalLimit - $leadsUsed['used'])
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Leads Remaining: ' . ($leadLimit - $leadsUsed['used'])
        ];
    }


    /**
     * Helper: Get current role and validate user in one place.
     * Returns array with either 'error' => false and 'getRole',
     * or 'error' => true and 'message'.
     */
    private static function getValidatedUser()
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error']) {
            return ['error' => true, 'message' => $getRole['message']];
        }

        $checkValidity = self::checkValidity($getRole['userdata']);
        if (!$checkValidity['valid']) {
            return ['error' => true, 'message' => $checkValidity['message']];
        }

        return ['error' => false, 'getRole' => $getRole];
    }

    /**
     * Helper: Determine user type from role data.
     * Returns 'customer', 'seller' or null.
     */
    private static function getUserType($getRole)
    {
        if (isset($getRole['user_id'])) {
            return 'customer';
        }
        if (isset($getRole['seller_id'])) {
            return 'seller';
        }
        return null;
    }

    /**
     * Fetch membership benefits decoded as array, or null if not found.
     */
    private static function getUserMembership($getRole, $membershipType)
    {
        $userTypeId = $membershipType . '_id';
        if (!isset($getRole[$userTypeId])) {
            return null;
        }

        $membership = MembershipTier::where([
            ['membership_type', $membershipType],
            ['membership_name', $getRole['role']]
        ])->first();

        return $membership ? json_decode($membership->membership_benefits, true) : null;
    }

    /**
     * Returns success or failure depending on accessType permission in benefits.
     */
    private static function getAccessStatus($benefits, $accessType)
    {
        return isset($benefits[$accessType]) && $benefits[$accessType] === 'yes'
            ? ['status' => 'success', 'message' => 'Access Granted']
            : ['status' => 'failure', 'message' => 'Access Denied'];
    }

    /** Public Methods **/

    public static function checksaleofferlimit()
    {
        $validation = self::getValidatedUser();
        if ($validation['error']) {
            return ['status' => 'failure', 'message' => $validation['message']];
        }

        $getRole = $validation['getRole'];

        // Restrict this function only to sellers
        if (isset($getRole['user_id'])) {
            return ['status' => 'failure', 'message' => 'Not Available for Customers'];
        }
        if (!isset($getRole['seller_id'])) {
            return ['status' => 'failure', 'message' => 'Contact Admin or Support Ticket'];
        }

        $benefits = self::getUserMembership($getRole, 'seller');
        if (!$benefits) {
            return ['status' => 'failure', 'message' => 'Membership details not found'];
        }

        $leadLimit = $benefits['sell_offer'];
        if ($leadLimit == -1) {
            return ['status' => 'success', 'message' => 'Unlimited Leads'];
        }

        $leadsUsed = self::SaleOfferMade($getRole['seller_id'], $leadLimit);
        if ($leadsUsed['used'] >= $leadLimit) {
            return ['status' => 'failure', 'message' => 'Sale Offer Used Up'];
        }

        return ['status' => 'success', 'message' => 'Sale Offer Remaining ' . $leadsUsed['remaining']];
    }

    public static function checkindustryjobsaccess()
    {
        $validation = self::getValidatedUser();
        if ($validation['error']) {
            return ['status' => 'failure', 'message' => $validation['message']];
        }

        $getRole = $validation['getRole'];
        $userType = self::getUserType($getRole);
        if (!$userType) {
            return ['status' => 'failure', 'message' => 'Membership details not found'];
        }

        $benefits = self::getUserMembership($getRole, $userType);
        if (!$benefits) {
            return ['status' => 'failure', 'message' => 'Membership details not found'];
        }

        return self::getAccessStatus($benefits, 'industry_jobs');
    }

    /**
     * Generic access checker for any access type.
     */
    public static function checkAccessByType($accessType)
    {
        $validation = self::getValidatedUser();
        if ($validation['error']) {
            return ['status' => 'failure', 'message' => $validation['message']];
        }

        $getRole = $validation['getRole'];
        $userType = self::getUserType($getRole);
        if (!$userType) {
            return ['status' => 'failure', 'message' => 'Membership details not found'];
        }

        $benefits = self::getUserMembership($getRole, $userType);
        if (!$benefits) {
            return ['status' => 'failure', 'message' => 'Membership details not found'];
        }

        return self::getAccessStatus($benefits, $accessType);
    }

    // Specific access checkers
    public static function checkaccessleads()
    {
        return self::checkAccessByType('access_leads');
    }

    public static function checkaccesssuppliers()
    {
        return self::checkAccessByType('access_suppliers');
    }

    public static function checkaccessjobs()
    {
        return self::checkAccessByType('access_jobs');
    }

    public static function checkifMember($added_by, $user_id)
    {
        if ($added_by == 'admin') {
            return 1;
        } else {
            $seller = Seller::find($user_id);
            if ($seller && $seller->membership != 'Free') {
                return 1;
            } else {
                return 0;
            }
        }
    }
}
