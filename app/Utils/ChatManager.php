<?php

namespace App\Utils;

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

class ChatManager
{
    public static function getProductsFooter()
    {
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $footer_prods = [];

        foreach ($categories->take(10) as $category) {
            $products = Product::where('category_id', $category['id'])
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();

            $footer_prods[] = [
                'id' => $category['id'],
                'name' => $category['name'],
                'products' => $products
            ];
        }

        return $footer_prods;
    }

    public static function unread_messages()
    {
        $userId = auth('customer')->id();
        $count = Chatting::where('user_id', $userId)
            ->where('seen_by_customer', 0)
            ->count();

        return $count > 9 ? '9+' : (string) $count;
    }

    public static function read_message()
    {
        Chatting::where('user_id', auth('customer')->id())
            ->where('seen_by_customer', 0)
            ->update(['seen_by_customer' => 1]);
    }

    public static function decoder($message)
    {
        return implode(',', json_decode($message, true));
    }

    public static function daysexpiry($message)
    {
        return Carbon::now()->diffInDays(Carbon::parse($message), false) > 31 ? 0 : 1;
    }

    public static function getjobapplierdetails($user_id, $method)
    {
        if ($method === 'cv') {
            return [[
                'userdata' => User::find($user_id),
                'jb' => CV::where('user_id', $user_id)->first()
            ]];
        }

        if ($method === 'form') {
            $profile = TableJobProfile::where('user_id', $user_id)->first();
            return [[
                'userdata' => $profile,
                'jb' => $profile
            ]];
        }

        return 0;
    }

    public static function getjobapplierdetailsless($user_id)
    {
        return User::find($user_id);
    }

    public static function getsellername($id)
    {
        if ($id === 'admin') return 'admin';

        $seller = Seller::find($id);
        return $seller ? trim("{$seller->f_name} {$seller->l_name}") : 'Admin';
    }

    public static function getstockname($id)
    {
        if ($id === 'admin') return 'admin';

        $seller = Seller::find($id);
        return $seller ? trim("{$seller->f_name} {$seller->l_name}") : 'Admin';
    }

    public static function getMembershipStatusCustomer($id)
    {
        if (!$id) return ['error' => 'Invalid ID'];

        $user = User::find($id);
        if (!$user) return ['error' => 'User not found'];

        $membership = Membership::where('membership_id', $user->id)->first();
        if (!$membership) return ['error' => 'Membership not found'];

        return match ($membership->membership_status) {
            'active' => ['status' => 'active', 'message' => 'You have Already Upgraded'],
            'inactive' => ['status' => 'inactive', 'message' => 'Your Plan is being Upgraded'],
            'suspended' => ['status' => 'suspended', 'message' => 'Your Plan is Suspended'],
            'expired' => ['status' => 'expired', 'message' => 'Your Plan is Expired'],
            default => ['status' => 'unknown', 'message' => 'Invalid Plan! Contact Admin'],
        };
    }

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

        return ['role' => 'web', 'user_id' => null];
    }

    public static function Leads()
    {
        $buyerLimit = json_decode(BusinessSetting::where('type', 'buyer')->value('value'), true)['limit'] ?? 10;
        $sellerLimit = json_decode(BusinessSetting::where('type', 'seller')->value('value'), true)['limit'] ?? 10;

        $buyerLeads = Leads::where('type', 'buyer')->take($buyerLimit)->get();
        $sellerLeads1 = Leads::where('type', 'seller')->where('role', 'admin')->take($sellerLimit)->get();
        $sellerLeads2 = Leads::where('type', 'seller')->where('role', 'seller')->where('active', 1)->get();

        return [
            'buyer' => $buyerLeads,
            'seller' => $sellerLeads1->merge($sellerLeads2),
        ];
    }

    public static function Suppliers()
    {
        $limit = json_decode(DB::table('business_settings')->where('type', 'topsupplier')->value('value'), true)['limit'] ?? 6;
        return Supplier::take((int) $limit)->get();
    }

    public static function IncreaseProductView($productId)
    {
        $product = Product::findOrFail($productId);
        $product->increment('views');
        return ['Success', 'Views Added Successfully'];
    }

    public static function GetTrendingProducts()
    {
        $limit = json_decode(DB::table('business_settings')->where('type', 'trendingproducts')->value('value'), true)['limit'] ?? 12;
        return Product::orderByDesc('views')->take((int) $limit)->get();
    }

    public static function getCategoryName($categoryId)
    {
        return Category::find($categoryId)?->name;
    }

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

        $country = Country::find((int) $countryId);

        return $country
            ? ['status' => 200, 'countryName' => $country->name, 'countryISO2' => $country->iso2]
            : ['status' => 404, 'message' => 'Country not found', 'countryName' => null, 'countryISO2' => null];
    }

    public static function getStateName($id)
    {
        return State::find($id)?->name;
    }

    public static function getCityName($id)
    {
        return City::find($id)?->name;
    }

    public static function getIndustryDetails($id)
    {
        if (!is_numeric($id)) {
            return ['status' => 400, 'message' => 'Invalid industry ID', 'name' => null];
        }

        $industry = Category::find((int) $id);

        return $industry
            ? ['status' => 200, 'name' => $industry->name]
            : ['status' => 404, 'message' => 'Industry not found', 'name' => null];
    }

    public static function fetchusername($id)
    {
        return User::find($id)?->name;
    }


    public static function getProductImage($id)
    {
        $product = Product::find($id);
        return $product ? $product->thumbnail : null;
    }

    public static function fetchImage($id)
    {
        $user = User::find($id);
        return $user ? $user->image : null;
    }

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

        switch ($type) {
            case IMAGETYPE_GIF:
                return imageCreateFromGif($filepath);
            case IMAGETYPE_JPEG:
                return imageCreateFromJpeg($filepath);
            case IMAGETYPE_PNG:
                return imageCreateFromPng($filepath);
            case IMAGETYPE_BMP:
                return imageCreateFromBmp($filepath);
            default:
                return false;
        }
    }

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

    private static function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

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
        return $lum > 0.5 ? '#000000' : '#FFFFFF';
    }

    public static function getProductName($id)
    {
        $product = Product::find($id);
        return $product ? $product->name : "Select A Product";
    }


    public static function getMessagersName($user_data, $type, $sender_type)
    {
        $validated = Validator::make((array) $user_data, [
            'user_id' => 'required|integer',
            'role' => 'required|string|in:customer,seller,admin',
        ]);

        if ($validated->fails()) {
            throw new \Exception($validated->errors()->first());
        }

        $messages = ChatsOther::where('receiver_type', $user_data['role'])
            ->where('receiver_id', $user_data['user_id'])
            ->where('type', $type)
            ->where('sender_type', $sender_type)
            ->get();

        // Group messages by sender
        $groupedMessages = $messages->groupBy('sender_id');

        foreach ($groupedMessages as $sender_id => &$messageGroup) {
            $unreadMessages = $messageGroup->where('is_read', 0)->count();
            $messageGroup['unread_messages'] = $unreadMessages;

            // Get average open status
            $openstatus = self::getavgopenstatus($type, $sender_id, $messageGroup->first()->sender_type);
            $messageGroup['openstatus'] = $openstatus;
        }

        return $groupedMessages;
    }

    public static function getchats($sender_data, $receiver_data, $type)
    {
        $chats = ChatsOther::where('type', $type)
            ->where(function ($query) use ($sender_data, $receiver_data) {
                $query->where([
                    ['sender_type', $sender_data['role']],
                    ['sender_id', $sender_data['user_id']],
                    ['receiver_id', $receiver_data['user_id']],
                    ['receiver_type', $receiver_data['role']],
                ])->orWhere([
                    ['sender_type', $receiver_data['role']],
                    ['sender_id', $receiver_data['user_id']],
                    ['receiver_id', $sender_data['user_id']],
                    ['receiver_type', $sender_data['role']],
                ]);
            })
            ->orderBy('sent_at', 'asc')
            ->get();

        return $chats->map(function ($chat) {
            return [
                "id" => $chat->id,
                "sender_id" => $chat->sender_id,
                "sender_type" => $chat->sender_type,
                "receiver_id" => $chat->receiver_id,
                "receiver_type" => $chat->receiver_type,
                "message" => $chat->message,
                "sent_at" => $chat->sent_at,
                "is_read" => $chat->is_read,
            ];
        });
    }

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

    public static function checkifsupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        $seller = Seller::find($user_data['user_id']);
        return $seller && $seller->vendor_type == 'supplier';
    }

    public static function checkconfirmsupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        $seller = Seller::find($user_data['user_id']);
        return $seller && $seller->suppliers_confirm_status == 1;
    }

    public static function checkStatusSupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        $seller = Seller::find($user_data['user_id']);

        if (!$seller) {
            Log::info("Seller not found, returning 2");
            return 2;
        }

        if ($seller->vendor_type == 'supplier') {
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

            if (!isset($currentRole['role']) || !in_array($currentRole['role'], ['customer', 'seller'])) {
                return [
                    'error' => true,
                    'message' => 'User not logged in or invalid role.',
                ];
            }

            $userId = $currentRole['user_id'];
            $role = $currentRole['role'];

            if ($role == 'customer') {
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

            if ($role == 'seller') {
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
            return [
                'error' => true,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ];
        }
    }

    private static function checkValidity($userdata)
    {
        if (!$userdata || !$userdata->membership_id) {
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
            ->distinct()
            ->count();

        $remaining = max($weeklyLimit - $leadsUsed, 0);

        return [
            'used' => $leadsUsed,
            'remaining' => $remaining,
        ];
    }


    private static function BuyLeadsUsedThisMonth($userId, $monthlyLimit, $leadType = 'buyer')
    {
        if (!$userId) {
            return [
                'used' => 0,
                'remaining' => 0
            ];
        }

        // Get the start and end of the current month
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Get all leads of the specified type
        $leadIds = Leads::where('type', $leadType)->pluck('id');

        // Filter ChatsOther by sender_id, lead_id, and date range
        $leadsByUser = ChatsOther::where('sender_id', $userId)
            ->whereIn('lead_id', $leadIds) // Filter by lead type
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->distinct()
            ->get();

        $used = $leadsByUser->count();
        $remaining = max($monthlyLimit - $used, 0);

        return [
            'used' => $used,
            'remaining' => $remaining
        ];
    }

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

        $roleDetails = $getRole['role'] === 'customer' ? 'customer' : 'seller';
        $membershipDetails = MembershipTier::where('membership_type', $roleDetails)
            ->where('membership_name', $getRole['role'])
            ->first()->membership_benefits;

        $membershipDetails = json_decode($membershipDetails, true);
        $leadslimit = $membershipDetails['buy_leads'];

        if ($leadslimit == -1) {
            return [
                'status' => 'success',
                'message' => 'Unlimited Leads'
            ];
        }

        // Determine the user's weekly or monthly limit
        $usedLeads = $getRole['role'] === 'Free'
            ? self::BuyLeadsUsedThisWeek($getRole['user_id'] ?? $getRole['seller_id'], $leadslimit)
            : self::BuyLeadsUsedThisMonth($getRole['user_id'] ?? $getRole['seller_id'], $leadslimit);

        if ($usedLeads['used'] >= $leadslimit) {
            return [
                'status' => 'failure',
                'message' => 'Leads Used Up. Wait for Next ' . ($getRole['role'] === 'Free' ? 'week' : 'month') . ' for Limit to reset.'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Leads Remaining: ' . $usedLeads['remaining']
        ];
    }

    private static function SellLeadsUsedThisWeek($userId, $weeklyLimit, $leadType = 'seller')
    {
        if (!$userId) {
            return [
                'used' => 0,
                'remaining' => 0
            ];
        }

        // Get the start and end of the current week
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // Get all leads of the specified type
        $leadIds = Leads::where('type', $leadType)->pluck('id');

        // Filter ChatsOther by sender_id, lead_id, and date range
        $leadsByUser = ChatsOther::where('sender_id', $userId)
            ->whereIn('lead_id', $leadIds) // Filter by lead type
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->distinct()
            ->get();

        $used = $leadsByUser->count();
        $remaining = max($weeklyLimit - $used, 0);

        return [
            'used' => $used,
            'remaining' => $remaining
        ];
    }


    private static function LeadsUsed($userId, $limit, $leadType, $timePeriod = 'month')
    {
        if (!$userId) {
            return [
                'used' => 0,
                'remaining' => 0
            ];
        }

        // Determine start and end of the specified time period
        $start = ($timePeriod == 'week') ? now()->startOfWeek() : now()->startOfMonth();
        $end = ($timePeriod == 'week') ? now()->endOfWeek() : now()->endOfMonth();

        // Filter by lead type and count the number of leads used by the user in the given time period
        $used = ChatsOther::where('sender_id', $userId)
            ->whereIn('lead_id', Leads::where('type', $leadType)->pluck('id'))
            ->whereBetween('created_at', [$start, $end])
            ->distinct()
            ->count();

        $remaining = max(0, $limit - $used);

        return [
            'used' => $used,
            'remaining' => $remaining
        ];
    }

    public static function checkLeadsLimit($leadType = 'buyer', $timePeriod = 'month')
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error'] === false) {
            $checkValidity = self::checkValidity($getRole['userdata']);
            if ($checkValidity['valid'] === true) {
                $userId = $getRole['user_id'] ?? $getRole['seller_id'];
                $membershipType = isset($getRole['user_id']) ? 'customer' : 'seller';
                $role = $getRole['role'];

                if ($userId) {
                    // Retrieve membership details once
                    $membershipDetails = MembershipTier::where('membership_type', $membershipType)
                        ->where('membership_name', $role)
                        ->first()->membership_benefits;
                    $membershipDetails = json_decode($membershipDetails, true);

                    // Handle unlimited leads scenario
                    if ($membershipDetails["{$leadType}_leads"] == -1) {
                        return [
                            'status' => 'success',
                            'message' => 'Unlimited Leads'
                        ];
                    }

                    // Determine lead limit and check used/remaining leads
                    $leadLimit = $membershipDetails["{$leadType}_leads"];
                    $leadsUsed = self::LeadsUsed($userId, $leadLimit, $leadType, $timePeriod);
                    $remainingLeadsMessage = "Leads Remaining: {$leadsUsed['remaining']}";

                    // Handle limit checks based on lead usage
                    if ($leadsUsed['used'] >= $leadLimit) {
                        return [
                            'status' => 'failure',
                            'message' => 'Leads Used Up. Wait for Next ' . ucfirst($timePeriod) . ' for Limit to reset.'
                        ];
                    } elseif ($leadsUsed['used'] < $leadLimit) {
                        return [
                            'status' => 'success',
                            'message' => $remainingLeadsMessage
                        ];
                    }
                }
            } else {
                return [
                    'status' => 'failure',
                    'message' => $checkValidity['message'],
                ];
            }
        } else {
            return [
                'status' => 'failure',
                'message' => $getRole['message'],
            ];
        }

        return [
            'status' => 'failure',
            'message' => 'Contact Admin or Support Ticket'
        ];
    }


    private static function CVUsed($userId, $limit, $leadType = 'seller', $timePeriod = 'month')
    {
        if (!$userId) return ['used' => 0, 'remaining' => 0];

        // Determine the time range based on the time period (week or month)
        $start = ($timePeriod == 'week') ? now()->startOfWeek() : now()->startOfMonth();
        $end = ($timePeriod == 'week') ? now()->endOfWeek() : now()->endOfMonth();

        // Get the lead IDs for the specified lead type
        $leadIds = Leads::where('type', $leadType)->pluck('id');

        // Count the number of leads used by the user in the given time period
        $used = ChatsOther::where('sender_id', $userId)
            ->whereIn('lead_id', $leadIds)
            ->whereBetween('created_at', [$start, $end])
            ->distinct()
            ->count();

        return [
            'used' => $used,
            'remaining' => max(0, $limit - $used)
        ];
    }

    private static function SaleOfferMade($userId, $limit, $leadType = 'seller')
    {
        if (!$userId) return ['used' => 0, 'remaining' => 0];

        // Count the number of active offers made by the user
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
        if ($accessCheck['status'] !== 'success') return $accessCheck;

        // Determine if user is a customer or seller
        $userType = isset($getRole['user_id']) ? 'customer' : 'seller';
        $userId = $getRole[$userType . '_id'] ?? null;

        if (!$userId) {
            return ['status' => 'failure', 'message' => 'Contact Admin or Support Ticket'];
        }

        // Get membership details
        $membership = MembershipTier::where([
            ['membership_type', $userType],
            ['membership_name', $getRole['role']]
        ])->first();

        $benefits = json_decode($membership->membership_benefits, true);
        $leadLimit = $benefits['no_of_cv'];

        if ($leadLimit == -1) {
            return ['status' => 'success', 'message' => 'Unlimited Leads'];
        }

        // Check for any extra limits from top-up
        $extraLimit = HelperUtil::getCvTopUpValue($userId, $getRole['role']);
        $totalLimit = $leadLimit + $extraLimit;

        // Check leads usage for the current period (week or month)
        $leadsUsed = ($getRole['role'] === 'Free')
            ? self::CVUsed($userId, $totalLimit, 'seller', 'week')  // For free users, check weekly
            : self::CVUsed($userId, $totalLimit, 'seller', 'month'); // For others, check monthly

        if ($leadsUsed['used'] >= $totalLimit) {
            return ['status' => 'failure', 'message' => 'Leads Used Up. Wait for the limit to reset.'];
        }

        // Handle top-up usage if the user has surpassed the free limit
        if ($leadsUsed['used'] >= $leadLimit && $extraLimit > 0) {
            HelperUtil::consumeCvTopUp($userId, $userType);
            return ['status' => 'success', 'message' => 'Using Top-Up. Leads Remaining: ' . ($totalLimit - $leadsUsed['used'])];
        }

        // Return remaining leads within the basic limit
        return ['status' => 'success', 'message' => 'Leads Remaining: ' . ($leadLimit - $leadsUsed['used'])];
    }


    private static function getUserMembership($getRole, $membershipType)
    {
        if (!isset($getRole[$membershipType . '_id'])) {
            return null;
        }

        $membership = MembershipTier::where([
            ['membership_type', $membershipType],
            ['membership_name', $getRole['role']]
        ])->first();

        return $membership ? json_decode($membership->membership_benefits, true) : null;
    }

    private static function getAccessStatus($benefits, $accessType)
    {
        return isset($benefits[$accessType]) && $benefits[$accessType] === 'yes'
            ? ['status' => 'success', 'message' => 'Access Granted']
            : ['status' => 'failure', 'message' => 'Access Denied'];
    }

    public static function checksaleofferlimit()
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error']) {
            return ['status' => 'failure', 'message' => $getRole['message']];
        }

        $checkValidity = self::checkValidity($getRole['userdata']);
        if (!$checkValidity['valid']) {
            return ['status' => 'failure', 'message' => $checkValidity['message']];
        }

        // Check if the user is a seller
        if (isset($getRole['user_id'])) {
            return ['status' => 'failure', 'message' => 'Not Available for Seller'];
        }

        if (!isset($getRole['seller_id'])) {
            return ['status' => 'failure', 'message' => 'Contact Admin or Support Ticket'];
        }

        // Fetch membership benefits for the seller
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
        $getRole = self::getCurrentRole();
        if ($getRole['error']) {
            return ['status' => 'failure', 'message' => $getRole['message']];
        }

        $checkValidity = self::checkValidity($getRole['userdata']);
        if (!$checkValidity['valid']) {
            return ['status' => 'failure', 'message' => $checkValidity['message']];
        }

        $userType = isset($getRole['user_id']) ? 'customer' : 'seller';
        $benefits = self::getUserMembership($getRole, $userType);

        if (!$benefits) {
            return ['status' => 'failure', 'message' => 'Membership details not found'];
        }

        return self::getAccessStatus($benefits, 'industry_jobs');
    }

    public static function checkAccessByType($accessType)
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error']) {
            return ['status' => 'failure', 'message' => $getRole['message']];
        }

        $checkValidity = self::checkValidity($getRole['userdata']);
        if (!$checkValidity['valid']) {
            return ['status' => 'failure', 'message' => $checkValidity['message']];
        }

        $userType = isset($getRole['user_id']) ? 'customer' : (isset($getRole['seller_id']) ? 'seller' : null);
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
}
