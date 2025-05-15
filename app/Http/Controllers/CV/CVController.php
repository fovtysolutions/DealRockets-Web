<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CV;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\CVService;
use Brian2694\Toastr\Toastr;
use App\Models\User;
use App\Models\JobAppliers;
use App\Models\Vacancies;

class CVController extends Controller
{
    public function index()
    {
        // Category Counter
        $categories = Category::withCount('vacancies')->orderBy('vacancies_count', 'DESC')->limit(8)->get();

        $jobspercategory = [];

        foreach ($categories as $category) {
            $jobspercategory[] = [
                'name' => $category->name,
                'count' => $category->vacancies_count,
                'image' => $category->icon ?? null,
            ];
        }
        $data['jobspercategory'] = $jobspercategory;

        // Avaliable Jobs
        $jobs = Vacancies::withCount('jobAppliers')->orderBy('job_appliers_count', 'DESC')->limit(8)->get();
        $data['jobs'] = $jobs;
        
        return view('web.cv',$data);
    }

    public function cvpublic(Request $request){
        $userId = Auth::guard('customer')->user() ? Auth::guard('customer')->id() : 0;
        $user = User::where('id', $userId)->first();
        $check_cv_exists = CV::where('user_id',  $userId)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string|max:255',
            'cv' => 'required|file|mimes:pdf,docx,doc|max:2048'
        ]);

        $storage = config('filesystems.disks.default') ?? 'public';
        if ($check_cv_exists) {
            Storage::disk($storage)->delete($check_cv_exists->image_path);

            // Handle file upload
            $cv = $request->file('cv');
            $name = time() . '_' . $cv->getClientOriginalName();
            $extension = $cv->getClientOriginalExtension();
            $imagePath = Storage::disk($storage)->putFileAs('cv', $cv, $name);

            // Store the CV data in the database
            $check_cv_exists->update([
                'name' => $request->name,
                'details' => $request->details,
                'image_path' => $imagePath,
            ]);

            toastr()->success('Successfully CV Submitted');
            return redirect()->back()->with('success', 'CV uploaded successfully!');    
        } else {
            // Handle file upload
            $cv = $request->file('cv');
            $name = time() . '_' . $cv->getClientOriginalName();
            $extension = $cv->getClientOriginalExtension();
            $imagePath = Storage::disk($storage)->putFileAs('cv', $cv, $name);

            // Store the CV data in the database
            CV::create([
                'name' => $request->name,
                'details' => $request->details,
                'image_path' => $imagePath,
                'user_id' => $userId,
            ]);

            toastr()->success('Successfully CV Submitted');
            return redirect()->back()->with('success', 'CV uploaded successfully!');    
        }
    }

    // Store function to upload a CV
    public function store(Request $request)
    {
        $userId = Auth::guard('customer')->user() ? Auth::guard('customer')->id() : 0;

        $user = User::where('id', $userId)->first();

        $check_cv_exists = CV::where('user_id',  $userId)->first();

        $name = $user->name;
        $detail = 'Resume Submitted through Application';

        // Validate the incoming request data
        $request->validate([
            'cv' => 'required|file|mimes:pdf,docx,doc,xlsx,jpg,jpeg,png,gif|max:2048',
            'jobid' => 'required',
        ]);

        $storage = config('filesystems.disks.default') ?? 'public';

        if ($check_cv_exists) {
            Storage::disk($storage)->delete($check_cv_exists->image_path);

            // Handle file upload
            $cv = $request->file('cv');
            $name = time() . '_' . $cv->getClientOriginalName();
            $extension = $cv->getClientOriginalExtension();
            $imagePath = Storage::disk($storage)->putFileAs('cv', $cv, $name);

            // Store the CV data in the database
            $check_cv_exists->update([
                'name' => $name,
                'details' => $detail,
                'image_path' => $imagePath,
            ]);
        } else {
            // Handle file upload
            $cv = $request->file('cv');
            $name = time() . '_' . $cv->getClientOriginalName();
            $extension = $cv->getClientOriginalExtension();
            $imagePath = Storage::disk($storage)->putFileAs('cv', $cv, $name);

            // Store the CV data in the database
            CV::create([
                'name' => $name,
                'details' => $detail,
                'image_path' => $imagePath,
                'user_id' => $userId,
            ]);
        }

        JobAppliers::create([
            'user_id' => $userId,
            'admin_id' => null,
            'jobid' => $request->jobid,
            'apply_via' => 'cv',
        ]);

        toastr()->success('Successfully Job Applied');
        return redirect()->back()->with('success', 'CV uploaded successfully!');
    }

    // List function to display all CVs with filters
    public function list(Request $request)
    {
        // Start with the query
        $query = CV::query();

        // Apply filters based on the request
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('details')) {
            $query->where('details', 'LIKE', '%' . $request->details . '%');
        }

        if ($request->filled('searchValue')) {
            $query->where('name', 'LIKE', '%' . $request->searchValue . '%');
        }

        $cvs = $query->get();
        $totalCvs = $cvs->count();
        $totCvsPage = CV::paginate(10); // Pagination for 10 items per page
        $name = CV::select('name')->distinct()->pluck('name');
        $details = CV::select('details')->distinct()->pluck('details');

        return view('admin-views.cv.list', compact('cvs', 'totalCvs', 'name', 'details', 'totCvsPage'));
    }

    // View function to display a single CV
    public function view($id)
    {
        $cv = CV::findOrFail($id);
        return view('admin-views.cv.view', compact('cv'));
    }

    // Edit function to retrieve and edit a CV
    public function edit($id)
    {
        $cv = CV::findOrFail($id);
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        return view('admin-views.cv.edit', compact('cv', 'languages', 'defaultLanguage'));
    }

    // Update function to update an existing CV
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string|max:255',
        ]);

        // Find the CV by id and update the data
        $cv = CV::findOrFail($id);

        $storage = config('filesystems.disks.default') ?? 'public';

        // Check if a new file was uploaded
        if ($request->hasFile('cv_file')) {
            $cvFile = $request->file('cv_file');
            $name = time() . '_' . $cvFile->getClientOriginalName();
            $imagePath = Storage::disk($storage)->putFileAs('cv_file', $cvFile, $name);

            // Update the CV data with the new file path
            $cv->update([
                'name' => $request->input('name'),
                'details' => $request->input('details'),
                'image_path' => $imagePath, // Update the file path if a new file is uploaded
            ]);
        } else {
            // Just update name and details if no file was uploaded
            $cv->update([
                'name' => $request->input('name'),
                'details' => $request->input('details'),
            ]);
        }
        
        return redirect()
            ->route('admin.cv.view', ['id' => $id])
            ->with('success', 'CV updated successfully.');
    }

    // Delete function to remove a CV
    public function delete($id)
    {
        $cv = CV::findOrFail($id);

        // Delete the associated file from storage if exists
        if ($cv->image_path) {
            Storage::disk('local')->delete($cv->image_path);
        }

        // Delete the CV record
        $cv->delete();

        return redirect()->route('admin.cv.list')->with('success', 'CV deleted successfully.');
    }
    public function getBulkImportView()
    {
        return view('admin-views.cv.bulk-import');
    }
    public function importBulkcv(Request $request, CVService $service)
    {
        $dataArray = $service->getImportcvService(request: $request, addedBy: 'admin');
        if (!$dataArray['status']) {
            Toastr::error($dataArray['message']);
            return back();
        }

        $this->productRepo->addArray(data: $dataArray['products']);
        Toastr::success($dataArray['message']);
        return back();
    }
}
