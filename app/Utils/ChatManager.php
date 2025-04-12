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
use App\Models\MembershipTier;
use App\Utils\CategoryManager;
use Error;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\B;

class ChatManager
{
    public static function getProductsFooter(){
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        $footer_prods = [];
        foreach ($categories->take(10) as $key => $value){
            $productsCate = Product::orderBy('views','desc')->where('category_id',$key+1)->take(5)->get();
            $footer_prods[] = [
                'id' => $value['id'],
                'name' => $value['name'],
                'products' => $productsCate
            ];
        }
        return $footer_prods;
    }

    public static function unread_messages()
    {
        $userId = auth('customer')->id();
        $userhist = Chatting::where('user_id', $userId);
        $read = $userhist->where('seen_by_customer', '0')->count();

        // Counter
        if ($read > 9) {
            $unread = "9+";
            return $unread;
        } else {
            $unread = $read;
            return $unread;
        }
    }

    public static function read_message()
    {
        $usedId = auth('customer')->id();
        $userhist = Chatting::where('user_id', $usedId)->where('seen_by_customer', '0');
        $userhist->update(['seen_by_customer' => 1]);
    }

    public static function decoder($message)
    {
        $decoded = implode(',', json_decode($message, true));
        return $decoded;
    }

    public static function daysexpiry($message)
    {
        $date = Carbon::parse($message);
        $now = Carbon::now();
        $diffinDays = $now->diffInDays($date, false);
        return $diffinDays > 31 ? 0 : 1;
    }

    public static function getjobapplierdetails($user_id, $method)
    {
        $user = User::where('id', $user_id)->first();
        if ($method == 'cv') {
            $cv = CV::where('user_id', $user_id)->first();
            $data[] = [
                'userdata' => $user,
                'jb' => $cv,
            ];
            return $data;
        } else if ($method == 'form') {
            $profile = TableJobProfile::where('user_id', $user_id)->first();
            $data[] = [
                'userdata' => $profile,
                'jb' => $profile,
            ];
            return $data;
        } else {
            // Send No Data
            return 0;
        }
    }

    public static function getjobapplierdetailsless($user_id)
    {
        $profile = User::where('id', $user_id)->first();
        return $profile;
    }

    public static function getsellername($id)
    {
        if ($id == 'admin') {
            return 'admin';
        } else {
            $seller = Seller::where('id', $id)->first();
            if ($seller) {
                $sellerfname = $seller->f_name;
                $sellerlname = $seller->l_name;
                $full_name = $sellerfname . ' ' . $sellerlname;
                return $full_name;
            } else {
                return 'Admin';
            }
        }
    }

    public static function getstockname($id)
    {
        if ($id == 'admin') {
            return 'admin';
        } else {
            $seller = Seller::where('id', $id)->first();
            if ($seller) {
                $sellerfname = $seller->f_name;
                $sellerlname = $seller->l_name;
                $full_name = $sellerfname . ' ' . $sellerlname;
                return $full_name;
            } else {
                return 'Admin';
            }
        }
    }

    public static function getMembershipStatusCustomer($id)
    {
        if ($id) {
            $user = User::find($id);
            if ($user) {
                $membership = Membership::where('membership_id', $user->id)->first();
                if ($membership) {
                    $membership_status = $membership->membership_status;

                    switch ($membership_status) {
                        case 'active':
                            return ['status' => 'active', 'message' => 'You have Already Upgraded'];
                        case 'inactive':
                            return ['status' => 'inactive', 'message' => 'Your Plan is being Upgraded'];
                        case 'suspended':
                            return ['status' => 'suspended', 'message' => 'Your Plan is Suspended'];
                        case 'expired':
                            return ['status' => 'expired', 'message' => 'Your Plan is Expired'];
                        default:
                            return ['status' => 'unknown', 'message' => 'Invalid Plan! Contact Admin'];
                    }
                } else {
                    return ['error' => 'Membership not found'];
                }
            } else {
                return ['error' => 'User not found'];
            }
        } else {
            return ['error' => 'Invalid ID'];
        }
    }

    public static function getRoleDetail()
    {
        if (auth('customer')->check()) {
            $role = 'customer';
            $userId = auth('customer')->user()->id;
        } else if (auth('seller')->check()) {
            $role = 'seller';
            $userId = auth('seller')->user()->id;
        } else if (auth('admin')->check()) {
            $role = 'admin';
            $userId = auth('admin')->user()->id;
        } else {
            $role = 'web';
            $userId = null;
        }
        return ['role' => $role, 'user_id' => $userId];
    }
    public static function Leads()
    {
        $getleads = json_decode(BusinessSetting::where('type', 'buyer')->first()->value, true)['limit'];
        $getsellers = json_decode(BusinessSetting::where('type', 'seller')->first()->value, true)['limit'];
        $buyerleads = Leads::where('type', 'buyer')->take($getleads)->get();
        $sellerleads1 = Leads::where('type', 'seller')->where('role','admin')->take($getsellers)->get();
        $sellerleads2 = Leads::where('type','seller')->where('role','seller')->where('active',1)->get();
        $sellerleads = array_merge($sellerleads1->toArray(),$sellerleads2->toArray());
        return ['buyer' => $buyerleads, 'seller' => $sellerleads];
    }

    public static function Suppliers()
    {
        // Fetch the limit from business_settings
        $limit = DB::table('business_settings')
            ->where('type', 'topsupplier')
            ->value('value');

        $limit = json_decode($limit, true)['limit'] ?? 6; // Default to 6 if no value found

        $suppliers = Supplier::take((int) $limit)->get();
        return $suppliers;
    }

    public static function IncreaseProductView($productid)
    {
        $getProduct = Product::findOrFail($productid);

        $currentViews = $getProduct->views;
        $getProduct->views = $currentViews + 1;
        $getProduct->save();

        return ['Success', 'Views Added Successfully'];
    }

    public static function GetTrendingProducts()
    {
        // Fetch the limit from business_settings
        $limit = DB::table('business_settings')
            ->where('type', 'trendingproducts')
            ->value('value');

        $limit = json_decode($limit, true)['limit'] ?? 12; // Default to 6 if no value found

        $getProducts = Product::orderBy('views', 'DESC')
            ->take((int) $limit)
            ->get();

        return $getProducts;
    }

    public static function getCategoryName($categoryId)
    {
        // Retrieve the category by id
        $category = Category::where('id', $categoryId)->first();

        // Check if category is found
        if ($category) {
            // Return the name of the category if found
            return $category->name;
        } else {
            // Return null if the category is not found
            return null;
        }
    }

    public static function getCountryDetails($countryId)
    {
        // Ensure countryId is an integer or a valid numeric string
        if (!is_numeric($countryId)) {
            return [
                'status' => 400,
                'message' => 'Invalid country ID',
                'countryName' => null,
                'countryISO2' => null,
            ];
        }

        $country = Country::find((int) $countryId);

        if ($country) {
            return [
                'status' => 200,
                'countryName' => $country->name,
                'countryISO2' => $country->iso2,
            ];
        } else {
            return [
                'status' => 404,
                'message' => 'Country not found',
                'countryName' => null,
                'countryISO2' => null,
            ];
        }
    }

    public static function getIndustryDetails($id)
    {
        // Ensure id is an integer or a valid numeric string
        if (!is_numeric($id)) {
            return [
                'status' => 400,
                'message' => 'Industry country ID',
                'name' => null,
            ];
        }

        $industry = Category::find((int) $id);

        if ($industry) {
            return [
                'status' => 200,
                'name' => $industry->name,
            ];
        } else {
            return [
                'status' => 404,
                'message' => 'Industry not found',
                'countryName' => null,
            ];
        }
    }

    public static function fetchusername($id)
    {
        $user_name = User::where('id', $id)->first()->name;
        return $user_name;
    }

    public static function getproductimage($id)
    {
        $prod_image = Product::where('id', $id)->first()->thumbnail;
        return $prod_image;
    }

    public static function fetchimage($id)
    {
        $image = User::where('id', $id)->first()->image;
        return $image;
    }

    private static function imageCreateFromAny($filepath)
    {

        $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize()

        $allowedTypes = array(
            1,  // [] gif
            2,  // [] jpg
            3,  // [] png
            6   // [] bmp
        );

        if (!in_array($type, $allowedTypes)) {

            return false;
        }

        switch ($type) {

            case 1:

                $im = imageCreateFromGif($filepath);

                break;

            case 2:

                $im = imageCreateFromJpeg($filepath);

                break;

            case 3:

                $im = imageCreateFromPng($filepath);

                break;

            case 6:

                $im = imageCreateFromBmp($filepath);

                break;
        }
        return $im;
    }

    public static function getimagecolorat($image, $x, $y)
    {
        try {
            $imagepath = public_path($image);

            $imageResource = self::imageCreateFromAny($imagepath);

            if (!$imageResource) {
                throw new Exception("Unable to load image: " . $imagepath);
            }

            $color = imagecolorat($imageResource, $x, $y);

            if ($color === false) {
                throw new Exception("Failed to retrieve color at coordinates ($x, $y) from image: " . $imagepath);
            }

            return strtoupper(dechex($color));
        } catch (Exception $e) {
            Log::info('Code Errored with Message' . $e->getMessage());
        }
    }

    private static function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        $rgb = array();
        $rgb['r'] = hexdec(substr($hex, 0, 2));
        $rgb['g'] = hexdec(substr($hex, 2, 2));
        $rgb['b'] = hexdec(substr($hex, 4, 2));

        return $rgb;
    }

    private static function luminance($rgb)
    {
        // Normalize RGB values to the range 0-1
        $r = $rgb['r'] / 255;
        $g = $rgb['g'] / 255;
        $b = $rgb['b'] / 255;

        // Apply the luminance formula
        $r = ($r <= 0.03928) ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = ($g <= 0.03928) ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = ($b <= 0.03928) ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);

        // Calculate luminance using the weighted sum
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    public static function getTextColorBasedOnBackground($hex)
    {
        $rgb = self::hexToRgb($hex);
        $lum = self::luminance($rgb);
        $color = $lum > 0.5 ? '#000000' : '#FFFFFF';
        return $color;
    }

    public static function getproductname($id)
    {
        $data = Product::where('id', $id)->first();
        if ($data){
            $name = $data->name;
            return $name;
        } else {
            return "Select A Product";
        }
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

        $messages = [];
        $groupedMessages = [];

        $allmessages = ChatsOther::where('receiver_type', $user_data['role'])
            ->where('receiver_id', $user_data['user_id'])
            ->where('type', $type)
            ->where('sender_type', $sender_type)
            ->get();

        foreach ($allmessages as $message) {
            if ($message->type == $type) {
                $messages[] = [
                    'sender_id' => $message->sender_id,
                    'sender_type' => $message->sender_type,
                    'receiver_id' => $message->receiver_id,
                    'receiver_type' => $message->receiver_type,
                    'message' => $message->message,
                    'stocksell_id' => $message->stocksell_id,
                    'suppliers_id' => $message->suppliers_id,
                    'leads_id' => $message->leads_id,
                    'sent_at' => $message->sent_at,
                    'is_read' => $message->is_read
                ];
            }
        }

        usort($messages, function ($a, $b) {
            return strtotime($b['sent_at']) <=> strtotime($a['sent_at']);
        });

        foreach ($messages as $message) {
            $groupedMessages[$message['sender_id']][] = $message;
        }

        foreach ($groupedMessages as $sender_id => &$messageGroup) {
            $unread_messages = 0;

            foreach ($messageGroup as $mess) {
                if ($mess['is_read'] === 0) {
                    $unread_messages++;
                }
            }
            $messageGroup['unread_messages'] = $unread_messages;

            $sender_id = $messageGroup[0]['sender_id'];
            $sender_type = $messageGroup[0]['sender_type'];
            $openstatus = self::getavgopenstatus($type, $sender_id, $sender_type);

            $messageGroup['openstatus'] = $openstatus;
        }
        unset($messageGroup);
        return $groupedMessages;
    }

    public static function getchats($sender_data, $reciever_data, $type)
    {
        $data = ChatsOther::where('type', $type)
            ->where(function ($query) use ($sender_data, $reciever_data) {
                $query->where([
                    ['sender_type', $sender_data['role']],
                    ['sender_id', $sender_data['user_id']],
                    ['receiver_id', $reciever_data['user_id']],
                    ['receiver_type', $reciever_data['role']],
                ])->orWhere([
                    ['sender_type', $reciever_data['role']],
                    ['sender_id', $reciever_data['user_id']],
                    ['receiver_id', $sender_data['user_id']],
                    ['receiver_type', $sender_data['role']],
                ]);
            })
            ->orderBy('sent_at', 'asc')->get();
        $cleandata = [];
        foreach ($data as $key => $value) {
            $cleandata[] = [
                "id" => $value->id,
                "sender_id" => $value->sender_id,
                "sender_type" => $value->sender_type,
                "receiver_id" => $value->receiver_id,
                "receiver_type" => $value->receiver_type,
                "message" => $value->message,
                "sent_at" => $value->sent_at,
                "is_read" => $value->is_read
            ];
        }
        return $cleandata;
    }

    public static function getavgopenstatus($type, $sender_id, $sender_type)
    {
        try {
            $user_chat_data = ChatsOther::where('type', $type)
                ->where('sender_id', $sender_id)
                ->where('sender_type', $sender_type)
                ->get();

            $average_status = $user_chat_data->avg('openstatus');
            return $average_status;
        } catch (Exception $e) {
            Log::error('Set Read Error: ' . $e->getMessage());
            return response('Error setting read status', 500);
        }
    }

    public static function checkifsupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        $seller = Seller::where('id', $user_data['user_id'])->first();
        if ($seller->vendor_type == 'supplier') {
            return true;
        } else {
            return false;
        }
    }

    public static function checkconfirmsupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        $seller = Seller::where('id', $user_data['user_id'])->first();
        if ($seller->suppliers_confirm_status == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkStatusSupplier()
    {
        $user_data = ChatManager::getRoleDetail();
        $seller = Seller::where('id', $user_data['user_id'])->first();
        if (isset($seller)) {
            if ($seller->vendor_type == 'supplier') {
                $supplier_status = $seller->suppliers_confirm_status;
                if ($supplier_status == 1) {
                    Log::info("Returned 1");
                    return 1;
                } else if ($supplier_status == 0) {
                    Log::info("Returned 0");
                    return 0;
                }
            } else if ($seller->vendor_type == 'vendor') {
                Log::info("Returned 1");
                return 1;
            }
        } else {
            Log::info("Returned 2");
            return 2;
        }
    }

    public static function RedirectSupplierDetails()
    {
        $supplier_status = self::checkStatusSupplier();

        switch ($supplier_status) {
            case 0:
                Log::info("Returned case 0");
                return [
                    'route' => 'vendor.supplier.status.update'
                ];
            case 1:
                Log::info("Returned case 1");
                return [
                    'route' => 'vendor.dashboard.index'
                ];
            default:
                Log::info("Returned case def");
                return [
                    'route' => 'error403'
                ];
        }
    }

    public static function getcapchastatus()
    {
        $capchastatus = BusinessSetting::where('type', 'recaptcha')->first();
        $getstatus = $capchastatus->status;
        return $getstatus;
    }

    private static function getCurrentRole()
    {
        try {
            $currentRole = self::getRoleDetail();
            if($currentRole['role'] == 'customer'){
                $userId = $currentRole['user_id'];
            } 
            if($currentRole['role'] == 'seller') {
                $sellerId = $currentRole['user_id'];
            }

            if (isset($userId)) {
                $user = auth('customer')->user(); // Retrieve the authenticated user
                if (!$user) {
                    // No user is logged in
                    return [
                        'error' => true,
                        'message' => 'No user is logged in.',
                    ];
                }

                // Ensure $userdata is not null
                if (!$user) {
                    return [
                        'error' => true,
                        'message' => 'User data not found.',
                    ];
                }
                return [
                    'error' => false,
                    'userdata' => $user,
                    'role' => $user->membership,
                    'status' => $user->membership_status,
                    'user_id' => $userId,
                ];
            } else if (isset($sellerId)) {
                $seller = auth('seller')->user(); // Retrieve the authenticated user
                if (!$seller) {
                    // No user is logged in
                    return [
                        'error' => true,
                        'message' => 'No seller is logged in.',
                    ];
                }

                // Ensure $userdata is not null
                if (!$seller) {
                    return [
                        'error' => true,
                        'message' => 'Seller data not found.',
                    ];
                }

                return [
                    'error' => false,
                    'userdata' => $seller,
                    'role' => $seller->membership,
                    'status' => $seller->membership_status,
                    'seller_id' => $sellerId,
                ];
            } else {
                return [
                    'error' => true,
                    'message' => 'User not Logged In or Invalid Login'
                ];
            }
        } catch (\Exception $e) {
            // Handle unexpected errors
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

        // Find the membership record based on the ID
        $membership = Membership::find($userdata->membership_id);

        if (!$membership) {
            return [
                'valid' => false,
                'message' => 'Membership not found.',
            ];
        }

        // Calculate the age of the membership
        $daysSinceCreated = now()->diffInDays($membership->created_at);

        if ($daysSinceCreated > 31) {
            // Expire the membership
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
        $getRole = self::getCurrentRole();
        if ($getRole['error'] === false) {
            $checkValidity = self::checkValidity($getRole['userdata']);
            if ($checkValidity['valid'] === true) {
                return [
                    'status' => 'success',
                    'membership' => $getRole['role'],
                ];
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
    }

    private static function BuyLeadsUsedThisWeek($userId, $weeklyLimit, $leadType = 'buyer')
    {
        if ($userId) {
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
            $remaining = $weeklyLimit - $used;

            return [
                'used' => $used,
                'remaining' => $remaining > 0 ? $remaining : 0
            ];
        }

        return [
            'used' => 0,
            'remaining' => 0
        ];
    }

    private static function BuyLeadsUsedThisMonth($userId, $monthlyLimit, $leadType = 'buyer')
    {
        if ($userId) {
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
            $remaining = $monthlyLimit - $used;

            return [
                'used' => $used,
                'remaining' => $remaining > 0 ? $remaining : 0
            ];
        }

        return [
            'used' => 0,
            'remaining' => 0
        ];
    }

    public static function checkbuyleadslimit()
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error'] === false) {
            $checkValidity = self::checkValidity($getRole['userdata']);
            if ($checkValidity['valid'] === true) {
                if (isset($getRole['user_id'])) {
                    $membershipDetails = MembershipTier::where('membership_type', 'customer')->where('membership_name', $getRole['role'])->first()->membership_benefits;
                    $membershipDetails = json_decode($membershipDetails,true);
                    if($membershipDetails['buy_leads'] == -1){
                        return [
                            'status' => 'success',
                            'message' => 'Unlimited Leads'
                        ];
                    }
                    if ($getRole['role'] == 'Free') {
                        $leadslimit = $membershipDetails['buy_leads'];

                        // Get Leads used this week
                        $leadsUsedWeek = self::BuyLeadsUsedThisWeek($getRole['user_id'], $leadslimit);
                        if ($leadsUsedWeek['used'] >= $leadslimit) {
                            return [
                                'status' => 'failure',
                                'message' => 'Leads Used Up. Wait for Next week for Limit to reset.'
                            ];
                        } else if ($leadsUsedWeek['used'] < $leadslimit) {
                            return [
                                'status' => 'success',
                                'message' => 'Leads Remaining' . $leadsUsedWeek['remaining']
                            ];
                        }
                    } else if ($getRole['role'] != 'Free') {
                        $leadslimit = $membershipDetails['buy_leads'];

                        // Get Leads used this week
                        $leadsUsedMonthly = self::BuyLeadsUsedThisMonth($getRole['user_id'], $leadslimit);
                        if ($leadsUsedMonthly['used'] >= $leadslimit) {
                            return [
                                'status' => 'failure',
                                'message' => 'Leads Used Up. Wait for Next week for Limit to reset.'
                            ];
                        } else if ($leadsUsedMonthly['used'] < $leadslimit) {
                            return [
                                'status' => 'success',
                                'message' => 'Leads Remaining' . $leadsUsedMonthly['remaining']
                            ];
                        } else {
                            return [
                                'status' => 'failure',
                                'message' => 'Contact Admin or Support Ticket'
                            ];
                        }
                    } else {
                        return [
                            'status' => 'failure',
                            'message' => 'Contact Admin or Support Ticket'
                        ];
                    }
                } else if (isset($getRole['seller_id'])) {
                    $membershipDetails = MembershipTier::where('membership_type', 'seller')->where('membership_name', $getRole['role'])->first()->membership_benefits;
                    $membershipDetails = json_decode($membershipDetails,true);
                    if($membershipDetails['buy_leads'] == -1){
                        return [
                            'status' => 'success',
                            'message' => 'Unlimited Leads'
                        ];
                    }
                    if ($getRole['role'] == 'Free') {
                        $leadslimit = $membershipDetails['buy_leads'];

                        // Get Leads used this week
                        $leadsUsedWeek = self::BuyLeadsUsedThisWeek($getRole['seller_id'], $leadslimit);
                        if ($leadsUsedWeek['used'] >= $leadslimit) {
                            return [
                                'status' => 'failure',
                                'message' => 'Leads Used Up. Wait for Next week for Limit to reset.'
                            ];
                        } else if ($leadsUsedWeek['used'] < $leadslimit) {
                            return [
                                'status' => 'success',
                                'message' => 'Leads Remaining' . $leadsUsedWeek['remaining']
                            ];
                        }
                    } else if ($getRole['role'] != 'Free') {
                        $leadslimit = $membershipDetails['buy_leads'];

                        // Get Leads used this week
                        $leadsUsedMonthly = self::BuyLeadsUsedThisMonth($getRole['seller_id'], $leadslimit);
                        if ($leadsUsedMonthly['used'] >= $leadslimit) {
                            return [
                                'status' => 'failure',
                                'message' => 'Leads Used Up. Wait for Next week for Limit to reset.'
                            ];
                        } else if ($leadsUsedMonthly['used'] < $leadslimit) {
                            return [
                                'status' => 'success',
                                'message' => 'Leads Remaining' . $leadsUsedMonthly['remaining']
                            ];
                        } else {
                            return [
                                'status' => 'failure',
                                'message' => 'Contact Admin or Support Ticket'
                            ];
                        }
                    } else {
                        return [
                            'status' => 'failure',
                            'message' => 'Contact Admin or Support Ticket'
                        ];
                    }
                } else {
                    return [
                        'status' => 'failure',
                        'membership' => $checkValidity['message'],
                    ];
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
    }

    private static function SellLeadsUsedThisWeek($userId, $weeklyLimit, $leadType = 'seller')
    {
        if ($userId) {
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
            $remaining = $weeklyLimit - $used;

            return [
                'used' => $used,
                'remaining' => $remaining > 0 ? $remaining : 0
            ];
        }

        return [
            'used' => 0,
            'remaining' => 0
        ];
    }

    private static function SellLeadsUsedThisMonth($userId, $monthlyLimit, $leadType = 'seller')
    {
        if ($userId) {
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
            $remaining = $monthlyLimit - $used;

            return [
                'used' => $used,
                'remaining' => $remaining > 0 ? $remaining : 0
            ];
        }

        return [
            'used' => 0,
            'remaining' => 0
        ];
    }

    public static function checksellleadslimit()
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error'] === false) {
            $checkValidity = self::checkValidity($getRole['userdata']);
            if ($checkValidity['valid'] === true) {
                if (isset($getRole['user_id'])) {
                    $membershipDetails = MembershipTier::where('membership_type', 'customer')->where('membership_name', $getRole['role'])->first()->membership_benefits;
                    $membershipDetails = json_decode($membershipDetails,true);
                    if($membershipDetails['sell_leads'] == -1){
                        return [
                            'status' => 'success',
                            'message' => 'Unlimited Leads'
                        ];
                    }
                    if ($getRole['role'] == 'Free') {
                        $leadslimit = $membershipDetails['sell_leads'];

                        // Get Leads used this week
                        $leadsUsedWeek = self::SellLeadsUsedThisWeek($getRole['user_id'], $leadslimit);
                        if ($leadsUsedWeek['used'] >= $leadslimit) {
                            return [
                                'status' => 'failure',
                                'message' => 'Leads Used Up. Wait for Next week for Limit to reset.'
                            ];
                        } else if ($leadsUsedWeek['used'] < $leadslimit) {
                            return [
                                'status' => 'success',
                                'message' => 'Leads Remaining' . $leadsUsedWeek['remaining']
                            ];
                        }
                    } else if ($getRole['role'] != 'Free') {
                        $leadslimit = $membershipDetails['sell_leads'];

                        // Get Leads used this week
                        $leadsUsedMonthly = self::SellLeadsUsedThisMonth($getRole['user_id'], $leadslimit);
                        if ($leadsUsedMonthly['used'] >= $leadslimit) {
                            return [
                                'status' => 'failure',
                                'message' => 'Leads Used Up. Wait for Next week for Limit to reset.'
                            ];
                        } else if ($leadsUsedMonthly['used'] < $leadslimit) {
                            return [
                                'status' => 'success',
                                'message' => 'Leads Remaining' . $leadsUsedMonthly['remaining']
                            ];
                        } else {
                            return [
                                'status' => 'failure',
                                'message' => 'Contact Admin or Support Ticket'
                            ];
                        }
                    } else {
                        return [
                            'status' => 'failure',
                            'message' => 'Contact Admin or Support Ticket'
                        ];
                    }
                } else if (isset($getRole['seller_id'])) {
                    $membershipDetails = MembershipTier::where('membership_type', 'seller')->where('membership_name', $getRole['role'])->first()->membership_benefits;
                    $membershipDetails = json_decode($membershipDetails,true);
                    if($membershipDetails['sell_leads'] == -1){
                        return [
                            'status' => 'success',
                            'message' => 'Unlimited Leads'
                        ];
                    }
                    if ($getRole['role'] == 'Free') {
                        $leadslimit = $membershipDetails['sell_leads'];

                        // Get Leads used this week
                        $leadsUsedWeek = self::SellLeadsUsedThisWeek($getRole['seller_id'], $leadslimit);
                        if ($leadsUsedWeek['used'] >= $leadslimit) {
                            return [
                                'status' => 'failure',
                                'message' => 'Leads Used Up. Wait for Next week for Limit to reset.'
                            ];
                        } else if ($leadsUsedWeek['used'] < $leadslimit) {
                            return [
                                'status' => 'success',
                                'message' => 'Leads Remaining' . $leadsUsedWeek['remaining']
                            ];
                        }
                    } else if ($getRole['role'] != 'Free') {
                        $leadslimit = $membershipDetails['sell_leads'];

                        // Get Leads used this week
                        $leadsUsedMonthly = self::SellLeadsUsedThisMonth($getRole['seller_id'], $leadslimit);
                        if ($leadsUsedMonthly['used'] >= $leadslimit) {
                            return [
                                'status' => 'failure',
                                'message' => 'Leads Used Up. Wait for Next week for Limit to reset.'
                            ];
                        } else if ($leadsUsedMonthly['used'] < $leadslimit) {
                            return [
                                'status' => 'success',
                                'message' => 'Leads Remaining' . $leadsUsedMonthly['remaining']
                            ];
                        } else {
                            return [
                                'status' => 'failure',
                                'message' => 'Contact Admin or Support Ticket'
                            ];
                        }
                    } else {
                        return [
                            'status' => 'failure',
                            'message' => 'Contact Admin or Support Ticket'
                        ];
                    }
                } else {
                    return [
                        'status' => 'failure',
                        'membership' => $checkValidity['message'],
                    ];
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
    }

    private static function CVUsedThisWeek($userId, $weeklyLimit, $leadType = 'seller')
    {
        if ($userId) {
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
            $remaining = $weeklyLimit - $used;

            return [
                'used' => $used,
                'remaining' => $remaining > 0 ? $remaining : 0
            ];
        }

        return [
            'used' => 0,
            'remaining' => 0
        ];
    }

    private static function CVUsedThisMonth($userId, $monthlyLimit, $leadType = 'seller')
    {
        if (!$userId) return ['used' => 0, 'remaining' => 0];

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $leadIds = Leads::where('type', $leadType)->pluck('id');
        $used = ChatsOther::where('sender_id', $userId)
            ->whereIn('lead_id', $leadIds)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->distinct()
            ->count();

        return [
            'used' => $used,
            'remaining' => max(0, $monthlyLimit - $used)
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
        if ($accessCheck['status'] !== 'success') return $accessCheck;

        $userType = isset($getRole['user_id']) ? 'customer' : 'seller';
        $userId = $getRole[$userType . '_id'] ?? null;

        if (!$userId) {
            return ['status' => 'failure', 'message' => 'Contact Admin or Support Ticket'];
        }

        $membership = MembershipTier::where([
            ['membership_type', $userType],
            ['membership_name', $getRole['role']]
        ])->first();

        $benefits = json_decode($membership->membership_benefits, true);
        $leadLimit = $benefits['no_of_cv'];

        if ($leadLimit == -1) {
            return ['status' => 'success', 'message' => 'Unlimited Leads'];
        }

        $extraLimit = HelperUtil::getCvTopUpValue($userId, $getRole['role']);
        $totalLimit = $leadLimit + $extraLimit;

        $leadsUsed = $getRole['role'] === 'Free'
            ? self::CVUsedThisWeek($userId, $totalLimit)
            : self::CVUsedThisMonth($userId, $totalLimit);

        if ($leadsUsed['used'] >= $totalLimit) {
            return ['status' => 'failure', 'message' => 'Leads Used Up. Wait for the limit to reset.'];
        }

        if ($leadsUsed['used'] >= $leadLimit && $extraLimit > 0) {
            HelperUtil::consumeCvTopUp($userId, $userType);
            return ['status' => 'success', 'message' => 'Using Top-Up. Leads Remaining: ' . ($totalLimit - $leadsUsed['used'])];
        }

        return ['status' => 'success', 'message' => 'Leads Remaining: ' . ($leadLimit - $leadsUsed['used'])];
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

        if (isset($getRole['user_id'])) {
            return ['status' => 'failure', 'message' => 'Not Available for Seller'];
        }

        if (!isset($getRole['seller_id'])) {
            return ['status' => 'failure', 'message' => 'Contact Admin or Support Ticket'];
        }

        $membership = MembershipTier::where([
            ['membership_type', 'seller'],
            ['membership_name', $getRole['role']]
        ])->first();

        $benefits = json_decode($membership->membership_benefits, true);
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
        $membership = MembershipTier::where([
            ['membership_type', $userType],
            ['membership_name', $getRole['role']]
        ])->first();

        $benefits = json_decode($membership->membership_benefits, true);
        $access = $benefits['industry_jobs'] ?? 'no';

        return $access === 'yes'
            ? ['status' => 'success', 'message' => 'Access Granted']
            : ['status' => 'failure', 'message' => 'Access Denied'];
    }    

    public static function checkAccessByType($accessType)
    {
        $getRole = self::getCurrentRole();
        if ($getRole['error'] !== false) {
            return [
                'status' => 'failure',
                'message' => $getRole['message'],
            ];
        }

        $checkValidity = self::checkValidity($getRole['userdata']);
        if ($checkValidity['valid'] !== true) {
            return [
                'status' => 'failure',
                'message' => $checkValidity['message'],
            ];
        }

        // Determine user type (customer or seller)
        if (isset($getRole['user_id'])) {
            $membershipType = 'customer';
        } elseif (isset($getRole['seller_id'])) {
            $membershipType = 'seller';
        } else {
            return [
                'status' => 'failure',
                'membership' => $checkValidity['message'],
            ];
        }

        $membership = MembershipTier::where('membership_type', $membershipType)
            ->where('membership_name', $getRole['role'])
            ->first();

        if (!$membership) {
            return [
                'status' => 'failure',
                'message' => 'Membership details not found',
            ];
        }

        $membershipDetails = json_decode($membership->membership_benefits, true);
        $access = $membershipDetails[$accessType] ?? 'no';

        if ($access === "yes") {
            return [
                'status' => 'success',
                'message' => 'Access Granted'
            ];
        } else {
            return [
                'status' => 'failure',
                'message' => 'Access Denied'
            ];
        }
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
