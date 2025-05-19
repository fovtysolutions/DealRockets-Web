<?php

namespace App\Utils;

use App\Models\Admin;
use App\Models\BusinessSetting;
use App\Models\Favourites;
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
/**
     * Get all search tags and counts for a user.
     */
    private static function getUserSearch(int $userId): array
    {
        $existingSearch = SearchHistUsers::where('user_id', $userId)->get(['tag', 'count']);

        if ($existingSearch->isNotEmpty()) {
            return [
                'status' => 'success',
                'data' => $existingSearch
            ];
        }

        return [
            'status' => 'failure',
            'data' => [],
            'message' => 'No search history found for this user.'
        ];
    }

    /**
     * Get products based on user's search tags combined with existing products.
     */
    public static function getSearchedProducts($existing)
    {
        if (!auth('customer')->check()) {
            return [
                'status' => 'success',
                'array' => $existing->toArray(),
            ];
        }

        $userId = auth('customer')->id();
        $response = self::getUserSearch($userId);

        if ($response['status'] !== 'success' || empty($response['data'])) {
            // No search tags found, return existing products only
            return [
                'status' => 'success',
                'array' => $existing->toArray(),
            ];
        }

        $searchTags = $response['data']->pluck('tag')->toArray();

        // Get matching tag IDs from Tag model
        $tagIds = Tag::whereIn('tag', $searchTags)->pluck('id');

        // Get product tags that match the tag IDs
        $productTags = ProductTag::whereIn('tag_id', $tagIds)->get();

        // Unique product IDs related to those tags
        $productIds = $productTags->pluck('product_id')->unique();

        // Retrieve matching products
        $products = Product::whereIn('id', $productIds)->get();

        // Combine searched products with existing ones
        $combinedArray = array_merge($products->toArray(), $existing->toArray());

        // Fetch limit from settings, default 12
        $limitJson = DB::table('business_settings')
            ->where('type', 'trendingproducts')
            ->value('value');

        $limit = 12; // Default limit
        if ($limitJson) {
            $decoded = json_decode($limitJson, true);
            if (isset($decoded['limit']) && is_numeric($decoded['limit'])) {
                $limit = (int) $decoded['limit'];
            }
        }

        $arraySliced = array_slice($combinedArray, 0, $limit);

        return [
            'status' => 'success',
            'products' => $products,
            'matched_tags' => $searchTags,
            'array' => $arraySliced,
        ];
    }

    /**
     * Get all tradeshows ordered by start date descending.
     */
    public static function getLatestTradeshows()
    {
        return Tradeshow::orderBy('start_date', 'desc')->get();
    }

    /**
     * Increase CV top-up amount for given user and user type.
     */
    public static function incCvTopUp(int $userId, string $userType, int $amount): array
    {
        try {
            $user = self::findUserByType($userId, $userType);
            if (!$user) {
                throw new Exception(ucfirst($userType) . " not found.");
            }

            $memBenefits = $user->mem_benefits ? json_decode($user->mem_benefits, true) : [];

            $memBenefits['cv_topup'] = ($memBenefits['cv_topup'] ?? 0) + $amount;

            $user->mem_benefits = json_encode($memBenefits);
            $user->save();

            return [
                'status' => 'success',
                'message' => 'CV Top-up increased successfully.',
                'new_cv_topup' => $memBenefits['cv_topup'],
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get CV top-up value for given user and user type.
     */
    public static function getCvTopUpValue(int $userId, string $userType): array
    {
        try {
            $user = self::findUserByType($userId, $userType);
            if (!$user) {
                throw new Exception(ucfirst($userType) . " not found.");
            }

            $memBenefits = $user->mem_benefits ? json_decode($user->mem_benefits, true) : [];
            $cvTopUp = $memBenefits['cv_topup'] ?? 0;

            return [
                'status' => 'success',
                'cv_topup' => $cvTopUp,
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Helper to find a user model instance by type.
     */
    private static function findUserByType(int $userId, string $userType)
    {
        switch ($userType) {
            case 'customer':
                return User::find($userId);
            case 'seller':
                return Seller::find($userId);
            default:
                throw new Exception("Invalid user type.");
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
        $checkIfSettingQuotation = BusinessSetting::where('type', 'quotation_enabled')->first();

        if ($checkIfSettingQuotation) {
            $settings = json_decode($checkIfSettingQuotation->value, true);
            $state = $settings['enabled'] ?? null;
            $runtime = isset($settings['runtime']) ? (int)$settings['runtime'] : null;
        }

        if (isset($state) && $state == 1 && isset($runtime)) {
            $currentDateTime = Carbon::now();
            $updated = false;

            // Only fetch quotations that have NOT been converted yet
            $quotations = Quotation::whereNull('converted_lead')->orderBy('created_at', 'desc')->get();

            foreach ($quotations as $quotation) {
                $createdDate = Carbon::parse($quotation->created_at);
                $ageInHours = $createdDate->diffInHours($currentDateTime);

                if ($ageInHours > $runtime) {
                    $quotation->converted_lead = 'active'; // Set status
                    $quotation->save();

                    // Transfer to leads
                    self::transferQuotationToLead($quotation);

                    $updated = true; // Mark that at least one quotation was updated
                }
            }

            if ($updated) {
                self::notifyAllAdmins();
                self::notifyAllVendors();
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
    public static function transferQuotationToLead($quotation)
    {
        try {
            // Check if the quotation has already been transferred to leads
            $existingLead = Leads::where('quotation_id', $quotation->id)->first();
            if ($existingLead) {
                return; // If already transferred, exit
            }
        
            // Map quotation data to lead data
            $leadData = [
                'type' => $quotation->type ?? null,
                'name' => $quotation->name ?? null,
                'country' => $quotation->country ?? null,
                'product_id' => $quotation->product_id ?? null,
                'industry' => $quotation->industry ?? null,
                'term' => $quotation->term ?? null,
                'unit' => $quotation->unit ?? null,
                'company_name' => $quotation->company_name ?? null,
                'contact_number' => $quotation->contact_number ?? null,
                'quantity_required' => $quotation->quantity ?? null,
                'buying_frequency' => $quotation->buying_frequency ?? null,
                'details' => $quotation->description ?? null,
                'role' => 'customer', // Default role if not provided
                'added_by' => $quotation->user_id,
                'created_at' => Carbon::now(),
                'quotation_id' => $quotation->id, // Track the quotation
            ];
        
            // Try to create a new lead
            $newLead = Leads::create($leadData);
        
            if (!$newLead) {
                // If lead creation somehow fails, revert quotation
                $quotation->converted_lead = null;
                $quotation->save();
            }
        } catch (\Exception $e) {
            // In case of any exception, also revert quotation
            $quotation->converted_lead = null;
            $quotation->save();
        
            // Optionally, log the error
            \Log::error('Failed to transfer quotation to lead: ' . $e->getMessage());
        }        
    }

    public static function notifyAllVendors(){
        Seller::query()->update(['lead_notif' => 1]);
    }

    public static function notifyAllAdmins(){
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

    public static function checkIfFavourite($listingId, $userId, $type)
    {
        // Check if the item is already favorited
        $favourite = Favourites::where('user_id', $userId)
                              ->where('listing_id', $listingId)
                              ->where('type', $type)
                              ->first();

        return $favourite ? true : false; // Return true if found, false otherwise
    }
}