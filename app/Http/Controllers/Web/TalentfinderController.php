<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\TableJobProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TalentfinderController extends Controller
{
    public function webindex(Request $request)
    {
        try {
            $name = $request->get('talentfinder');
            $category = $request->get('categoryid');

            $talentfinderQuery = TableJobProfile::query();

            if (!empty($name)) {
                $talentfinderQuery->where('full_name', 'like', '%' . $name . '%');
            }

            $data['items'] = $talentfinderQuery->paginate(9);

            // Filters Data with null checks
            $data['currencies'] = TableJobProfile::distinct()
                ->whereNotNull('currency')
                ->where('currency', '!=', '')
                ->pluck('currency')
                ->filter()
                ->unique()
                ->values();

            // Process skills with proper null and JSON validation
            $data['keywords'] = TableJobProfile::whereNotNull('skills')
                ->where('skills', '!=', '')
                ->pluck('skills')
                ->filter()
                ->flatMap(function ($item) {
                    try {
                        // Try to decode as JSON first
                        $decoded = json_decode($item, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            return $decoded;
                        }
                        
                        // Fallback: treat as comma-separated string
                        $cleaned = str_replace(['[', ']', '"'], '', $item);
                        return explode(',', $cleaned);
                    } catch (\Exception $e) {
                        Log::warning('Error processing skills: ' . $e->getMessage());
                        return [];
                    }
                })
                ->map(function ($item) {
                    $label = trim($item);
                    return [
                        'label' => $label,
                        'slug'  => Str::slug($label),
                    ];
                })
                ->filter(fn($item) => !empty($item['label']))
                ->unique('slug')
                ->values();

            $data['countries'] = Country::all();
            
            $data['jobtitle'] = TableJobProfile::distinct()
                ->whereNotNull('desired_position')
                ->where('desired_position', '!=', '')
                ->pluck('desired_position')
                ->filter()
                ->unique()
                ->values();

            // Get membership status with proper error handling
            if (Auth('customer')->check()) {
                try {
                    $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
                    if (isset($membership['error'])) {
                        $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
                    }
                } catch (\Exception $e) {
                    Log::warning('Error getting membership status: ' . $e->getMessage());
                    $membership = ['status' => 'NotMade', 'message' => 'Membership Not Available'];
                }
            } else {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Available'];
            }
            
            $data['membership'] = $membership;
            return view('web.talentfinder', $data);
            
        } catch (\Exception $e) {
            Log::error('Error in webindex: ' . $e->getMessage());
            
            // Return with empty data in case of error
            $data = [
                'items' => collect()->paginate(9),
                'currencies' => collect(),
                'keywords' => collect(),
                'countries' => collect(),
                'jobtitle' => collect(),
                'membership' => ['status' => 'NotMade', 'message' => 'Service temporarily unavailable']
            ];
            
            return view('web.talentfinder', $data);
        }
    }

    public function get_dynamic_data(Request $request)
    {
        try {
            // Validate request parameters
            $request->validate([
                'search_filter' => 'nullable|string|max:255',
                'min_salary' => 'nullable|numeric|min:0',
                'max_salary' => 'nullable|numeric|min:0',
                'currencies' => 'nullable|array',
                'currencies.*' => 'string|max:10',
                'keywords' => 'nullable|array',
                'keywords.*' => 'string|max:100',
                'job_types' => 'nullable|array',
                'job_types.*' => 'string|max:50',
                'countries' => 'nullable|array',
                'countries.*' => 'numeric',
                'jobtitles' => 'nullable|array',
                'jobtitles.*' => 'string|max:100',
                'min_experience' => 'nullable|numeric|min:0|max:50',
                'max_experience' => 'nullable|numeric|min:0|max:50',
                'page' => 'nullable|numeric|min:1'
            ]);

            $query = TableJobProfile::query();

            // Text Search (search_filter) - search in full_name and desired_position
            if ($request->filled('search_filter')) {
                $searchTerm = $request->get('search_filter');
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('full_name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('desired_position', 'like', '%' . $searchTerm . '%');
                });
            }

            // Salary Range
            if ($request->filled('min_salary') || $request->filled('max_salary')) {
                $minSalary = $request->get('min_salary', 0);
                $maxSalary = $request->get('max_salary', 999999999);
                
                $query->where(function ($q) use ($minSalary, $maxSalary) {
                    $q->whereNotNull('desired_salary')
                      ->whereBetween('desired_salary', [(int) $minSalary, (int) $maxSalary]);
                });
            }

            // Currency Filter
            if ($request->filled('currencies') && is_array($request->get('currencies'))) {
                $query->whereIn('currency', $request->get('currencies'));
            }

            // Keywords (skills)
            if ($request->filled('keywords') && is_array($request->get('keywords'))) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->get('keywords') as $keyword) {
                        $q->orWhere('skills', 'LIKE', '%' . $keyword . '%');
                    }
                });
            }

            // Job Titles
            if ($request->filled('jobtitles') && is_array($request->get('jobtitles'))) {
                $query->whereIn('desired_position', $request->get('jobtitles'));
            }

            // Job Types
            if ($request->filled('job_types') && is_array($request->get('job_types'))) {
                $query->whereIn('employment_type', $request->get('job_types'));
            }

            // Countries
            if ($request->filled('countries') && is_array($request->get('countries'))) {
                $query->whereIn('country', $request->get('countries'));
            }

            // Experience Level
            if ($request->filled('min_experience')) {
                $query->where('years_of_experience', '>=', (int) $request->get('min_experience'));
            }

            if ($request->filled('max_experience')) {
                $query->where('years_of_experience', '<=', (int) $request->get('max_experience'));
            }

            $page = $request->get('page', 1);

            // Paginate the filtered results
            $items = $query->paginate(6, ['*'], 'page', $page);
            
            // Get membership status with proper error handling
            if (Auth('customer')->check()) {
                try {
                    $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
                    if (isset($membership['error'])) {
                        $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
                    }
                } catch (\Exception $e) {
                    Log::warning('Error getting membership status: ' . $e->getMessage());
                    $membership = ['status' => 'NotMade', 'message' => 'Membership Not Available'];
                }
            } else {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Available'];
            }

            // Generate views
            $html = view('web.dynamic-partials.dynamic-talentfinder', compact('items','membership'))->render();
            $mobhtml = view('web.dynamic-partials.dynamic-mobtalentfinder', compact('items','membership'))->render();
            $pagination = $items->links('custom-paginator.custom')->render();

            return response()->json([
                'html' => $html,
                'mobhtml' => $mobhtml,
                'pagination' => $pagination,
                'total' => $items->total(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in get_dynamic_data: ' . $e->getMessage());
            
            return response()->json([
                'html' => '<div class="alert alert-danger">Error loading data. Please try again.</div>',
                'mobhtml' => '<div class="alert alert-danger">Error loading data. Please try again.</div>',
                'pagination' => '',
                'error' => 'Failed to load data'
            ], 500);
        }
    }

    public function get_data_candidate(Request $request)
    {
        try {
            $candidateid = $request->get('id');
            
            if (empty($candidateid)) {
                return response()->json(['error' => 'Candidate ID is required'], 400);
            }

            $candetails = TableJobProfile::find($candidateid);
            
            if (!$candetails) {
                return response()->json(['error' => 'Candidate not found'], 404);
            }

            // Safely decode JSON fields with null checks
            $skills = '';
            if (!empty($candetails->skills)) {
                try {
                    $skillsArray = json_decode($candetails->skills, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($skillsArray)) {
                        $skills = implode(',', $skillsArray);
                    } else {
                        $skills = $candetails->skills; // Use as-is if not valid JSON
                    }
                } catch (\Exception $e) {
                    $skills = $candetails->skills;
                }
            }

            $languages = '';
            if (!empty($candetails->languages)) {
                try {
                    $languagesArray = json_decode($candetails->languages, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($languagesArray)) {
                        $languages = implode(',', $languagesArray);
                    } else {
                        $languages = $candetails->languages; // Use as-is if not valid JSON
                    }
                } catch (\Exception $e) {
                    $languages = $candetails->languages;
                }
            }

            // Create response array with processed data
            $response = $candetails->toArray();
            $response['skills'] = $skills;
            $response['languages'] = $languages;

            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('Error in get_data_candidate: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve candidate data'], 500);
        }
    }
}
