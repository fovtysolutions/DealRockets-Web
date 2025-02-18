<?php

namespace App\Utils;

use App\Models\Admin;
use App\Models\BusinessSetting;
use App\Models\Leads;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Quotation;
use App\Models\SearchHistUsers;
use App\Models\Seller;
use App\Models\Tag;
use App\Models\Tradeshow;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class HelperUtil
{
    private static function get_user_search($userId)
    {
        // Fetch all searches for the given user ID
        $existing_search = SearchHistUsers::where('user_id', $userId)->get(['tag', 'count']);
    
        if ($existing_search->isNotEmpty()) {
            // Return the tags and their counts
            return [
                'status' => 'success',
                'data' => $existing_search
            ];
        }
    
        // Return a failure response if no data is found
        return [
            'status' => 'failure',
            'data' => [],
            'message' => 'No search history found for this user.'
        ];
    }
    
    public static function getsearchedproducts($existing)
    {
        if(auth('customer')->check()){
            // Get the authenticated user's ID
            $userId = auth('customer')->id();

            // Get the user's search tags
            $response = self::get_user_search($userId);

            // Check if there are any tags in the response
            if ($response['status'] === 'success' && !empty($response['data'])) {
                $searchTags = $response['data']->pluck('tag')->toArray(); // Extract tags as an array

                // Get the IDs of tags in the Tag model that match the user's search tags
                $tagIds = Tag::whereIn('tag', $searchTags)->pluck('id');

                // Find product tags that match the tag IDs
                $productTags = ProductTag::whereIn('tag_id', $tagIds)->get();

                // Get the unique product IDs associated with the matching tags
                $productIds = $productTags->pluck('product_id')->unique();

                // Retrieve the products using the product IDs
                $products = Product::whereIn('id', $productIds)->get();

                $combinedArray = array_merge($products->toArray(),$existing->toArray());
                
                $limit = DB::table('business_settings')
                ->where('type', 'trendingproducts')
                ->value('value');

                $limit = json_decode($limit, true)['limit'] ?? 12;
                
                $arraySliced = array_slice($combinedArray,0,$limit);

                // Return the products and tags
                return [
                    'status' => 'success',
                    'products' => $products,
                    'matched_tags' => $searchTags,
                    'array' => $arraySliced,
                ];
            } else if ($response['status'] === 'failure'){
                return [
                    'status' => 'success',
                    'array' => $existing->toArray(),
                ];
            }
        } else if(!auth('customer')->check()) {
            return [
                'status' => 'success',
                'array' => $existing->toArray(),
            ];
        } else {
            // If no tags match or no search history is found, return failure
            return [
                'status' => 'failure',
                'message' => 'No matching products found for the user search tags.',
            ];
        }
    }
    
    public static function getLatestTradeshows(){
        $allTradeshows = Tradeshow::orderBy('show_date','desc')->get();
        $toArray = $allTradeshows->toArray();
        $recentTradeshows = array_splice($toArray,0,2);
        return $recentTradeshows;
    }

    public static function IncCVTopUp($userId, $userType, $amount) {
        try {
            // Determine the model to use based on user type
            switch ($userType):
                case 'customer':
                    $user = User::find($userId);
                    if (!$user) {
                        throw new Exception("User not found.");
                    }
                    break;
    
                case 'seller':
                    $user = Seller::find($userId);
                    if (!$user) {
                        throw new Exception("Seller not found.");
                    }
                    break;
    
                default:
                    throw new Exception("Invalid user type.");
            endswitch;
    
            // Decode the existing mem_benefits JSON or initialize an empty array
            $memBenefits = $user->mem_benefits ? json_decode($user->mem_benefits, true) : [];
    
            // Increase the cv_topup by the specified amount
            if (!isset($memBenefits['cv_topup'])) {
                $memBenefits['cv_topup'] = 0;
            }
            $memBenefits['cv_topup'] += $amount;
    
            // Encode back to JSON and update the mem_benefits field
            $user->mem_benefits = json_encode($memBenefits);
            $user->save();
    
            // Return success response
            return [
                'status' => 'success',
                'message' => 'CV Top-up increased successfully.',
                'new_cv_topup' => $memBenefits['cv_topup']
            ];
    
        } catch (Exception $e) {
            // Return error message
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public static function getCvTopUpValue($userId, $userType) {
        try {
            // Determine the model to use based on user type
            switch ($userType):
                case 'customer':
                    $user = User::find($userId);
                    if (!$user) {
                        throw new Exception("User not found.");
                    }
                    break;
    
                case 'seller':
                    $user = Seller::find($userId);
                    if (!$user) {
                        throw new Exception("Seller not found.");
                    }
                    break;
    
                default:
                    throw new Exception("Invalid user type.");
            endswitch;
    
            // Decode the existing mem_benefits JSON
            $memBenefits = $user->mem_benefits ? json_decode($user->mem_benefits, true) : [];
    
            // Get the cv_topup value or return 0 if not set
            $cvTopUp = isset($memBenefits['cv_topup']) ? $memBenefits['cv_topup'] : 0;
    
            // Return the cv_topup value
            return [
                'status' => 'success',
                'cv_topup' => $cvTopUp
            ];
    
        } catch (Exception $e) {
            // Return error message
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public static function consumeCvTopUp($userId, $userType)
    {
        try {
            // Determine the model to use based on user type
            switch ($userType):
                case 'customer':
                    $user = User::find($userId);
                    if (!$user) {
                        throw new Exception("User not found.");
                    }
                    break;

                case 'seller':
                    $user = Seller::find($userId);
                    if (!$user) {
                        throw new Exception("Seller not found.");
                    }
                    break;

                default:
                    throw new Exception("Invalid user type.");
            endswitch;

            // Decode the existing mem_benefits JSON or initialize an empty array
            $memBenefits = $user->mem_benefits ? json_decode($user->mem_benefits, true) : [];

            // Decrease the cv_topup by 1 if it exists and is greater than 0
            if (isset($memBenefits['cv_topup']) && $memBenefits['cv_topup'] > 0) {
                $memBenefits['cv_topup'] -= 1;
            }

            // Encode back to JSON and update the mem_benefits field
            $user->mem_benefits = json_encode($memBenefits);
            $user->save();

            return [
                'status' => 'success',
                'message' => 'CV Top-Up consumed successfully.'
            ];

        } catch (Exception $e) {
            // Return error message
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public static function automatedQuotation()
    {   
        $checkIfSettingQuotation = BusinessSetting::where('type','quotation_enabled')->first();
        $state = json_decode($checkIfSettingQuotation,true)['enabled'];

        if ($state == 1){
            // Get all quotations, ordered by the most recent first
            $quotations = Quotation::orderBy('created_at', 'desc')->get();

            foreach ($quotations as $quotation) {
                // Get the current date and the quotation's creation date
                $currentDate = Carbon::now();
                $createdDate = Carbon::parse($quotation->created_at);

                // Calculate the age of the quotation in days
                $ageInDays = $createdDate->diffInDays($currentDate);

                // Check if the quotation is over 7 days old
                if ($ageInDays > 7) {
                    // Set the converted_lead field to active
                    $quotation->converted_lead = 'active'; // Assuming "active" is the required value
                    $quotation->save();

                    // Transfer data to leads if not already transferred
                    self::transferQuotationToLead($quotation);
                    self::notifyAllAdmins();
                    self::notifyAllVendors();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Quotations updated successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Quotations are Manual'
            ]);
        }
    }

    // Private function to transfer quotation to lead
    private static function transferQuotationToLead($quotation)
    {
        // Check if the quotation has already been transferred to leads
        $existingLead = Leads::where('quotation_id', $quotation->id)->first();
        if ($existingLead) {
            return; // If already transferred, exit
        }

        // Map quotation data to lead data
        $leadData = [
            'type' => $quotation->type,
            'name' => $quotation->name,
            'country' => $quotation->country,
            'product_id' => $quotation->product_id ?? '',
            'industry' => $quotation->industry,
            'term' => $quotation->term,
            'unit' => $quotation->unit,
            'company_name' => $quotation->company_name ?? '',
            'contact_number' => $quotation->contact_number,
            'quantity_required' => $quotation->quantity,
            'buying_frequency' => $quotation->buying_frequency,
            'details' => $quotation->details,
            'role' => 'customer', // Default role if not provided
            'added_by' => $quotation->user_id,
            'created_at' => Carbon::now()->toDateString(),
            'quotation_id' => $quotation->id // Keep track of the source quotation
        ];

        // Create a new lead record
        Leads::create($leadData);
    }

    private static function notifyAllVendors(){
        Seller::query()->update(['lead_notif' => 1]);
    }

    private static function notifyAllAdmins(){
        Admin::query()->update(['lead_notif' => 1]);
    }

    public static function getLeadNotif() {
        try {
            if (auth('seller')->check()) {
                $seller = auth('seller')->user();
                if ($seller->lead_notif == 1) {
                    return [
                        'status' => 'success',
                        'notif' => 1,
                        'error' => 'No Error'
                    ];
                }
            } else if (auth('admin')->check()) {
                $admin = auth('admin')->user();
                if ($admin->lead_notif == 1) {
                    return [
                        'status' => 'success',
                        'notif' => 1,
                        'error' => 'No Error'
                    ];
                }
            }
    
            return [
                'status' => 'fail',
                'notif' => 0,
                'error' => 'No Notification'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'fail',
                'error' => $e->getMessage()
            ];
        }
    }
}