<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Utils\CategoryManager;
use Illuminate\Support\Facades\Auth;
use App\Models\Vacancies;
use Illuminate\Support\Facades\Storage;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\JobAppliers;
use App\Models\TableJobProfile;
use App\Utils\ChatManager;
use Brian2694\Toastr\Toastr;
use Illuminate\Support\Carbon;
use App\Models\ShortlistCandidates;
use App\Models\JobCategory;
use App\Models\User;

class JobseekerController extends Controller
{
    protected function validateJobRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'salary' => 'nullable|numeric',
            'employment_type' => 'required|in:full-time,part-time,contract,freelance,internship',
            'status' => 'required|in:active,inactive,closed',
            'category' => 'required|max:255',
            'company_name' => 'required|max:255',
            'company_address' => 'nullable',
            'company_website' => 'nullable|url',
            'company_email' => 'nullable|email',
            'company_phone' => 'nullable|max:255',
            'company_logo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'location' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'state' => 'nullable|max:255',
            'country' => 'nullable|max:255',
            'experience_required' => 'nullable|integer',
            'education_level' => 'nullable|max:255',
            'skills_required' => 'nullable|string',
            'certifications_required' => 'nullable|string',
            'visa_sponsorship' => 'required|boolean',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'application_process' => 'nullable|string',
            'application_link' => 'nullable|url',
            'featured' => 'nullable|boolean',
            'vacancies' => 'required|integer|min:1',
            'remote' => 'required|boolean',
        ]);
    }

    protected function validateJobForm(Request $request)
    {
        return $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'alternate_email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'nationality' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'highest_education' => 'nullable|string|max:100',
            'field_of_study' => 'nullable|string|max:255',
            'university_name' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'additional_courses' => 'nullable|string',
            'certifications' => 'nullable|string',
            'languages' => 'nullable|string',
            'skills' => 'nullable|string',
            'bio' => 'nullable|string',
            'linkedin_profile' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'years_of_experience' => 'nullable|integer',
            'current_position' => 'nullable|string|max:255',
            'current_employer' => 'nullable|string|max:255',
            'work_experience' => 'nullable|string',
            'desired_position' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'desired_salary' => 'nullable|numeric',
            'relocation' => 'nullable|boolean',
            'industry' => 'nullable|string|max:255',
            'preferred_locations' => 'nullable|string',
            'open_to_remote' => 'nullable|boolean',
            'available_immediately' => 'nullable|boolean',
            'availability_date' => 'nullable|date',
            'references' => 'nullable|string',
            'hobbies' => 'nullable|string',
            'has_drivers_license' => 'nullable|boolean',
            'visa_status' => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:100',
            'has_criminal_record' => 'nullable|boolean',
            'is_verified' => 'nullable|boolean',
            'short_term_goal' => 'nullable|string|max:255',
            'long_term_goal' => 'nullable|string|max:255',
            'seeking_internship' => 'nullable|boolean',
            'open_to_contract' => 'nullable|boolean',
            'github_profile' => 'nullable|url|max:255',
            'behance_profile' => 'nullable|url|max:255',
            'twitter_profile' => 'nullable|url|max:255',
            'personal_website' => 'nullable|url|max:255',
            'portfolio_items' => 'nullable|string',
            'videos' => 'nullable|string',
            'profile_views' => 'nullable|integer',
            'applications_sent' => 'nullable|integer',
            'connections' => 'nullable|integer',
        ]);
    }

    public function webindex(Request $request)
    {
        // Get categories with counting and priority-wise sorting
        $newcategories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();

        // Get the category filter from the URL if present
        $categoryId = $request->get('categoryid');
        $vacancy = $request->get('vacancy');

        $location = $request->get('location');
        $time = $request->get('time');
        $company = $request->get('company');
        $jobType = $request->get('job_type');
        $experienceLevelFrom = $request->get('experience_level_from');
        $experienceLevelTo = $request->get('experience_level_to');
        $remote = $request->get('remote');

        // Fetch job vacancies, optionally filtered by category and other filters
        $jobseekerQuery = Vacancies::query();

        $jobseekerQuery->where('Approved', '1');
        $jobseekerQuery->where('status', 'active');

        // Apply filters based on URL parameters
        if ($location) {
            $jobseekerQuery->where('location', $location);
        }

        if ($categoryId){
            $jobseekerQuery->where('category',$categoryId);
        }

        if ($time) {
            // Time filter logic
            $date = now()->subDays($time); // Subtract the number of days based on the selected time range
            $jobseekerQuery->whereDate('created_at', '>=', $date);
        }

        if ($company) {
            $jobseekerQuery->where('company_name', $company);
        }

        if ($jobType) {
            $jobseekerQuery->where('employment_type', $jobType);
        }

        if ($experienceLevelFrom) {
            $jobseekerQuery->where('experience_required', '>=', $experienceLevelFrom);
        }

        if ($experienceLevelTo) {
            $jobseekerQuery->where('experience_required', '<=', $experienceLevelTo);
        }

        if ($remote == '1') {
            $jobseekerQuery->where('remote', 1);
        }

        // Get the filtered job vacancies
        $jobseeker = $jobseekerQuery->paginate(20);

        $userId = Auth::guard('customer')->user() ? Auth::guard('customer')->id() : 0;

        $countries = Country::all();
        $profile = TableJobProfile::where('user_id', $userId)->first();

        if ($profile) {
            // Decoding Some Inputs
            $profile->languages = json_decode($profile->languages, true);
            $profile->languages = implode(',', $profile->languages);

            $profile->skills = json_decode($profile->skills, true);
            $profile->skills = implode(',', $profile->skills);

            $profile->preferred_locations = json_decode($profile->preferred_locations, true);
            $profile->preferred_locations = implode(',', $profile->preferred_locations);

            $profile->references = json_decode($profile->references, true);
            $profile->references = implode(',', $profile->references);

            $profile->portfolio_items = json_decode($profile->portfolio_items, true);
            $profile->portfolio_items = implode(',', $profile->portfolio_items);

            $profile->videos = json_decode($profile->videos, true);
            $profile->videos = implode(',', $profile->videos);
        }

        // Get distinct values for locations, times, companies, job types, and experience levels
        $locations = Vacancies::distinct()->pluck('location');
        $times = Vacancies::distinct()->pluck('created_at');
        $companies = Vacancies::distinct()->pluck('company_name');
        $jobTypes = Vacancies::distinct()->pluck('employment_type');
        $experienceLevels = Vacancies::distinct()->pluck('experience_required');

        // Pass all data to the view
        return view('web.jobseeker', compact('profile', 'jobseeker', 'countries', 'locations', 'times', 'companies', 'jobTypes', 'experienceLevels','newcategories'));
    }

    public function updateStatus(Request $request)
    {
        $vacancy = Vacancies::findOrFail($request->vacancy_id);

        if ($vacancy) {
            $vacancy->approved = $request->approved;
            $vacancy->save();

            toastr()->success('Status Updated Successfully');

            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Vacancy not found!'], 404);
    }

    public function get_data_from_job($id)
    {
        $data = Vacancies::where('id', $id)->first();

        $user = ChatManager::getRoleDetail();
        $userId = $user['user_id'];

        $job_applied = JobAppliers::where('user_id', $userId)->where('jobid', $id)->first();

        $job_self = $userId == $data->user_id ? true : false;

        $response = [
            'job_data' => $data,
            'job_applied' => $job_applied ? true : false,
            'self_job' => $job_self,
        ];

        // Return response as JSON
        return response()->json($response);
    }

    public function decodeIfEncoded($value)
    {
        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }

    public function adminindex(Request $request)
    {
        // Fetch filter parameters from the request
        $category = $request->get('category');
        $status = $request->get('status');
        $employment_type = $request->get('employment_type');
        $sort_by = $request->get('sort_by', 'title'); // Default sort by title
        $sort_order = $request->get('sort_order', 'asc'); // Default to ascending order

        // Start the query
        $vacancies = Vacancies::query();

        // Apply category filter if it's provided
        if ($category) {
            $vacancies = $vacancies->where('category', 'like', '%' . $category . '%');
        }

        // Apply status filter if it's provided
        if ($status) {
            $vacancies = $vacancies->where('status', $status);
        }

        // Apply employment type filter if it's provided
        if ($employment_type) {
            $vacancies = $vacancies->where('employment_type', $employment_type);
        }

        // Sort the results based on the user's selection
        $vacancies = $vacancies->orderBy($sort_by, $sort_order);

        // Paginate the results
        $vacancies = $vacancies->paginate(10);

        // Pass the data to the view
        return view('admin-views.jobseekers.index', [
            'vacancies' => $vacancies,
            'category' => $category,
            'status' => $status,
            'employment_type' => $employment_type,
            'sort_by' => $sort_by,
            'sort_order' => $sort_order,
            'categories' => CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting(), // Assuming you have a categories table
        ]);
    }

    public function create()
    {
        // Get categories for the dropdown
        $categories = JobCategory::where('active','1')->get();
        $countries = Country::all();

        // Return the create view with the categories
        return view('admin-views.jobseekers.add', [
            'countries' => $countries,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $storage = config('filesystems.disks.default') ?? 'public';

        try {
            // Validating Data - Vacancy
            $this->validateJobRequest($request);

            // Handle file upload for company logo
            if ($request->hasFile('company_logo')) {
                $companyLogo = $request->file('company_logo');
                $logoName = time() . '_' . $companyLogo->getClientOriginalName();
                $logoPath = Storage::disk($storage)->putFileAs('company_logos', $companyLogo, $logoName);
            } else {
                $logoPath = null; // If no logo is uploaded, set it to null
            }

            $userId = Auth::Guard('admin')->user()->id;

            // Create a new vacancy
            Vacancies::create([
                'title' => $request->title,
                'description' => $request->description,
                'salary' => $request->salary,
                'employment_type' => $request->employment_type,
                'status' => $request->status,
                'category' => $request->category,
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_website' => $request->company_website,
                'company_email' => $request->company_email,
                'company_phone' => $request->company_phone,
                'company_logo' => $logoPath,
                'location' => $request->location,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'experience_required' => $request->experience_required,
                'education_level' => $request->education_level,
                'skills_required' => json_encode(explode(',', $request->skills_required)), // Encode to JSON
                'certifications_required' => json_encode(explode(',', $request->certifications_required)),
                'visa_sponsorship' => $request->visa_sponsorship,
                'benefits' => json_encode(explode(',', $request->benefits)), // Encode to JSON
                'application_deadline' => $request->application_deadline,
                'application_process' => $request->application_process,
                'application_link' => $request->application_link,
                'featured' => $request->featured ?? 0,
                'vacancies' => $request->vacancies,
                'remote' => $request->remote,
                'user_id' => '',
                'admin_id' => $userId,
                'Approved' => 1,
            ]);

            // Redirect with success message
            return redirect()->route('admin.jobvacancy.list')->with('success', 'Vacancy created successfully.');
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Vacancy creation failed: ' . $e->getMessage());

            // Return back with an error message
            return back()
                ->withInput()
                ->with('error', 'An error occurred while creating the vacancy: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Fetch the job vacancy by its ID
        $vacancy = Vacancies::findOrFail($id);
        $category = JobCategory::where('id', $vacancy->category)->value('name');
        $country = Country::where('id', $vacancy->country)->value('name');
        $state = State::where('id', $vacancy->state)->value('name');
        $city = City::where('id', $vacancy->city)->value('name');
        // Return the view and pass the vacancy data
        return view('admin-views.jobseekers.show', compact('vacancy', 'category', 'country', 'state', 'city'));
    }

    public function edit($id)
    {
        $vacancy = Vacancies::findOrFail($id);

        $vacancy_skills = $vacancy->skills_required ? json_decode($vacancy->skills_required, true) : [];
        $vacancy_certs = $vacancy->certifications_required ? json_decode($vacancy->certifications_required, true) : [];
        $vacancy_benefits = $vacancy->benefits ? json_decode($vacancy->benefits, true) : [];

        $vacancy->skills_required = implode(',', $vacancy_skills);
        $vacancy->certifications_required = implode(',', $vacancy_certs);
        $vacancy->benefits = implode(',', $vacancy_benefits);

        $categories = JobCategory::where('active','1')->get();
        $countries = Country::all();
        return view('admin-views.jobseekers.edit', compact('vacancy', 'categories', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $vacancy = Vacancies::findOrFail($id);

        $storage = config('filesystems.disks.default') ?? 'public';

        // Handle file upload for company logo
        if ($request->hasFile('company_logo')) {
            $companyLogo = $request->file('company_logo');
            $logoName = time() . '_' . $companyLogo->getClientOriginalName();
            $logoPath = Storage::disk($storage)->putFileAs('company_logos', $companyLogo, $logoName);
        } else {
            $logoPath = $vacancy->company_logo; // Retain the existing logo if no new file is uploaded
        }

        // Update the vacancy
        $updatedata = [
            'title' => $request->title,
            'description' => $request->description,
            'salary' => $request->salary,
            'employment_type' => $request->employment_type,
            'status' => $request->status,
            'category' => $request->category,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_website' => $request->company_website,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'company_logo' => $logoPath,
            'location' => $request->location,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'experience_required' => $request->experience_required,
            'education_level' => $request->education_level,
            'skills_required' => json_encode(explode(',', $this->decodeIfEncoded($request->skills_required))),
            'certifications_required' => json_encode(explode(',', $this->decodeIfEncoded($request->certifications_required))),
            'visa_sponsorship' => $request->visa_sponsorship,
            'benefits' => json_encode(explode(',', $this->decodeIfEncoded($request->benefits))),
            'application_deadline' => $request->application_deadline,
            'application_process' => $request->application_process,
            'application_link' => $request->application_link,
            'featured' => $request->featured ?? 0,
            'vacancies' => $request->vacancies,
            'remote' => $request->remote,
            'Approved' => 1,
        ];

        $vacancy->update($updatedata);

        // Redirect with success message
        return redirect()->route('admin.jobvacancy.list')->with('success', 'Job updated successfully.');
    }

    public function destroy($id)
    {
        $vacancy = Vacancies::findOrFail($id);
        $vacancy->delete();

        return redirect()->back()->with('success', 'Job deleted successfully');
    }

    public function applybyform(Request $request)
    {
        $user = Auth::guard('customer')->user()->id;
        $storage = config('filesystems.disks.default') ?? 'public';

        // Validation for the incoming request
        $validated = $this->validateJobForm($request);

        $validated['user_id'] = $user;
        $validated['languages'] = json_encode(explode(',', $validated['languages']));
        $validated['skills'] = json_encode(explode(',', $validated['skills']));
        $validated['preferred_locations'] = json_encode(explode(',', $validated['preferred_locations']));
        $validated['references'] = json_encode(explode(',', $validated['references']));
        $validated['portfolio_items'] = json_encode(explode(',', $validated['portfolio_items']));
        $validated['videos'] = json_encode(explode(',', $validated['videos']));

        // Fetch existing profile
        $profile = TableJobProfile::where('user_id', $user)->first();

        try {
            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $profile_photo = $request->file('profile_photo');
                $profilephoto_name = time() . '_' . $profile_photo->getClientOriginalName();
                $validated['profile_photo'] = Storage::disk($storage)->putFileAs('profile_photos', $profile_photo, $profilephoto_name);
            }

            // Handle resume upload
            if ($request->hasFile('resume')) {
                $resume = $request->file('resume');
                $resume_name = time() . '_' . $resume->getClientOriginalName();
                $validated['resume'] = Storage::disk($storage)->putFileAs('profile_resume', $resume, $resume_name);
            }

            if ($profile) {
                // Update existing profile with validated data
                $profile->update($validated);
            } else {
                // Create new profile if not exists
                TableJobProfile::create($validated);
            }

            JobAppliers::create([
                'user_id' => $user,
                'admin_id' => null,
                'jobid' => $request->jobid,
                'apply_via' => 'form',
            ]);

            toastr()->success('Successfully Job Applied');

            // Return success response
            return response()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Failed to update job profile for user ' . $user . ': ' . $e->getMessage());

            // Return error response
            return redirect()
                ->back()
                ->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function customer_create_job(Request $request)
    {
        $userId = Auth::guard('customer')->user()->id;

        $storage = config('filesystems.disks.default') ?? 'public';

        try {
            // Validating Data - Vacancy
            $this->validateJobRequest($request);

            // Handle file upload for company logo
            if ($request->hasFile('company_logo')) {
                $companyLogo = $request->file('company_logo');
                $logoName = time() . '_' . $companyLogo->getClientOriginalName();
                $logoPath = Storage::disk($storage)->putFileAs('company_logos', $companyLogo, $logoName);
            } else {
                $logoPath = null; // If no logo is uploaded, set it to null
            }

            // Create a new vacancy
            Vacancies::create([
                'title' => $request->title,
                'description' => $request->description,
                'salary' => $request->salary,
                'employment_type' => $request->employment_type,
                'status' => $request->status,
                'category' => $request->category,
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_website' => $request->company_website,
                'company_email' => $request->company_email,
                'company_phone' => $request->company_phone,
                'company_logo' => $logoPath,
                'location' => $request->location,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'experience_required' => $request->experience_required,
                'education_level' => $request->education_level,
                'skills_required' => json_encode(explode(',', $request->skills_required)), // Encode to JSON
                'certifications_required' => json_encode(explode(',', $request->certifications_required)),
                'visa_sponsorship' => $request->visa_sponsorship,
                'benefits' => json_encode(explode(',', $request->benefits)), // Encode to JSON
                'application_deadline' => $request->application_deadline,
                'application_process' => $request->application_process,
                'application_link' => $request->application_link,
                'featured' => $request->featured ?? 0,
                'vacancies' => $request->vacancies,
                'remote' => $request->remote,
                'user_id' => $userId,
                'admin_id' => null,
                'Approved' => 0,
            ]);

            toastr()->success('Job Created Successfully');

            // Redirect with success message
            return redirect()->route('jobseeker')->with('success', 'Vacancy created successfully.');
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Vacancy creation failed: ' . $e->getMessage());

            // Return back with an error message
            return back()
                ->withInput()
                ->with('error', 'An error occurred while creating the vacancy: ' . $e->getMessage());
        }
    }
    public function customerjob_destroy($id)
    {
        $vacancy = Vacancies::findOrFail($id);
        $vacancy->delete();

        toastr()->success('Job Deleted Successfully');

        return redirect()->back()->with('success', 'Job deleted successfully');
    }

    public function customerjob_extend($id)
    {
        $vacancy = Vacancies::findOrFail($id);
        $vacancy->updated_at = Carbon::now();
        $vacancy->save();

        toastr()->success('Job Status Extended');

        return response()->with('success', 'Job Successfully Extended');
    }

    public function customerjob_status(Request $request)
    {
        // Find the job vacancy by its ID
        $vacancy = Vacancies::findOrFail($request->job_id);

        // Update the job status
        $vacancy->status = $request->job_status;
        $vacancy->save(); // Save the changes

        toastr()->success('Job Status Updated');

        // Return a JSON response
        return redirect()->back()->with(['message' => 'Job status updated successfully.']);
    }

    public function customer_shortlist(Request $request)
    {

        $validatedData = $request->validate([
            'jobid' => 'required|integer|exists:vacancies,id',
            'applier_id' => 'required|integer|exists:users,id',
            'recruiter_id' => 'required|integer|exists:users,id',
        ]);

        ShortlistCandidates::create([
            'jobid' => $validatedData['jobid'],
            'applier_id' => $validatedData['applier_id'],
            'recruiter_id' => $validatedData['recruiter_id'],
        ]);

        toastr()->success('Candidate Shortlisted Successfully');

        return redirect()->back()->with(['messge' => 'Candidate Shortlisted Successfully']);
    }

    public function getapplicants($id)
    {
        $applicants = JobAppliers::where('jobid', $id)->get();
        return count($applicants);
    }

    public function getCountry($id)
    {
        $countryname = Country::where('id', $id)->first()->name; // Directly access the 'name' property
        return $countryname;
    }

    public function getState($id)
    {
        $statename = State::where('id', $id)->first()->name; // Directly access the 'name' property
        return $statename;
    }

    public function getCity($id)
    {
        $cityname = City::where('id', $id)->first()->name; // Directly access the 'name' property
        return $cityname;
    }

    public function catindex()
    {
        try {
            // Display all job categories
            $categories = JobCategory::all();
            return view('admin-views.jobseekers.category_management.list', compact('categories'));
        } catch (QueryException $e) {
            // Catch any database related errors and show a message
            toastr()->error('Error fetching categories: ' . $e->getMessage());
            return redirect()->route('admin.jobvacancy.category.list');
        }
    }

    public function catcreate()
    {
        try {
            // Show the form to create a new job category
            return view('admin-views.jobseekers.category_management.add');
        } catch (\Exception $e) {
            toastr()->error('Error loading the category creation form: ' . $e->getMessage());
            return redirect()->route('admin.jobvacancy.category.list');
        }
    }

    public function catstore(Request $request)
    {
        try {
            // Validate and store the new job category
            $request->validate([
                'name' => 'required|string|max:255',
                'active' => 'required|in:1,0',
            ]);

            JobCategory::create($request->all());

            toastr()->success('Category Successfully Created');
            return redirect()->route('admin.jobvacancy.category.list')
                ->with('success', 'Job Category created successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during create operation
            toastr()->error('Error creating category: ' . $e->getMessage());
            return redirect()->route('admin.jobvacancy.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.jobvacancy.category.list');
        }
    }

    public function catupdate(Request $request, JobCategory $jobCategory)
    {
        try {
            // Validate and update the job category
            $request->validate([
                'name' => 'required|string|max:255',
                'active' => 'required|in:1,0',
            ]);

            $jobCategory->update($request->all());

            toastr()->success('Category Successfully Updated');
            return redirect()->route('admin.jobvacancy.category.list')
                ->with('success', 'Job Category updated successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during update operation
            toastr()->error('Error updating category: ' . $e->getMessage());
            return redirect()->route('admin.jobvacancy.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.jobvacancy.category.list');
        }
    }

    public function catdestroy(JobCategory $jobCategory)
    {
        try {
            // Delete the job category
            $jobCategory->delete();

            toastr()->success('Category Successfully Deleted');
            return redirect()->route('admin.jobvacancy.category.list')
                ->with('success', 'Job Category deleted successfully.');
        } catch (QueryException $e) {
            // Catch database-related errors during delete operation
            toastr()->error('Error deleting category: ' . $e->getMessage());
            return redirect()->route('admin.jobvacancy.category.list');
        } catch (\Exception $e) {
            // Catch general errors
            toastr()->error('Unexpected error: ' . $e->getMessage());
            return redirect()->route('admin.jobvacancy.category.list');
        }
    }

    public function consultant_membership(Request $request){
        if ($request->isMethod('get')){
            $query = User::where('typerole','findtalent');
            $search = $request->input('search');
            if ($search){
                $query = $query->where(function($q) use ($search){
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }
            $consultants = $query->paginate(10);
            return view('admin-views.jobseekers.consultant_membership.index',compact('consultants'));
        }
    }

    public function job_applications(Request $request)
    {
        if ($request->isMethod('get')) {
            // Start the query
            $query = JobAppliers::with(['user', 'job']); // Eager load related user and job data

            // Get the search input
            $search = $request->input('search');

            // Apply search filter if provided
            if ($search) {
                $query = $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
                })->orWhereHas('job', function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            }

            // Paginate the results
            $data['jobapplications'] = $query->paginate(10);

            // Return the view with data
            return view('admin-views.jobseekers.job_applications.index', $data);
        }
    }                   

    public function registered_candidates(Request $request)
    {
        if ($request->isMethod('get')) {
            $query = TableJobProfile::query(); // Replace with your model

            $search = $request->input('search');
            if ($search) {
                $query = $query->where('full_name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%")
                               ->orWhere('phone', 'LIKE', "%{$search}%");
            }

            $data['candidates'] = $query->paginate(10);

            return view('admin-views.jobseekers.registered_candidates.index', $data);
        }
    }
}
