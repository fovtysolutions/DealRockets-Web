<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Services\QuotationService;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\User;
use App\Models\Category;
use App\Models\Leads;
use Brian2694\Toastr\Toastr;
use App\Utils\ChatManager;

class QuotatioController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'type' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'term' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'buying_frequency' => 'required|string|max:255',
        ]);

        // Get the user and role details
        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'];
        $role = $userdata['role'];

        // Create a new Quotation entry
        Quotation::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'user_id' => $userId,
            'role' => $role,
            'type' => $request->input('type'),
            'country' => $request->input('country'),
            'industry' => $request->input('industry'),
            'term' => $request->input('term'),
            'unit' => $request->input('unit'),
            'buying_frequency' => $request->input('buying_frequency'),
        ]);

        // Notify the user of success
        toastr()->success('Quotation Submitted Successfully');

        // Redirect to the home route
        return redirect()->back()->with('success', 'Quotation Successfully Created');
    }

    public function list(Request $request)
    {
        // Start with the query
        $query = Quotation::query();

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('quantity')) {
            $query->where('quantity', 'LIKE', '%' . $request->quantity . '%');
        }

        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->description . '%');
        }

        if ($request->filled('searchValue')){
            $query->where('name','LIKE','%'.$request->searchValue.'%');
        }

        $quotations = $query->get();
        $totalquotations = $quotations->count();
        $totquotationspage = Quotation::paginate(10);
        $name = Quotation::select('name')->distinct()->pluck('name');
        $quantity = Quotation::select('quantity')->distinct()->pluck('quantity');
        $description = Quotation::select('description')->distinct()->pluck('description');

        return view(
            'admin-views.quotation.list',
            compact(
                'quotations',
                'totalquotations',
                'totquotationspage',
                'name',
                'quantity',
                'description',
            )
        );
    }

    public function view($id)
    {
        $quotations = Quotation::findOrFail($id);
        return view('admin-views.quotation.view', compact('quotations'));
    }

    public function edit($id)
    {
        $quotation = Quotation::findOrFail($id);
        $categories = Category::all();
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        return view('admin-views.quotation.edit', compact('quotation', 'categories', 'languages', 'defaultLanguage'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|string',
            'description' => 'required|string',
        ]);

        // Update the lead record
        $quotations = Quotation::findOrFail($id);
        $quotations->update(array_merge($validatedData));

        return redirect()->route('admin.quotations.view', ['id' => $id])->with('success', 'Lead updated successfully.');
    }

    public function delete($id)
    {
        $quotations = Quotation::findOrFail($id);
        $quotations->delete();

        return redirect()->route('admin.quotations.list')->with('success', 'Supplier deleted successfully.');
    }

    public function getBulkImportView()
    {
        return view('admin-views.quotation.bulk-import');
    }

    public function importBulkquotation(Request $request, QuotationService $service)
    {
        $userdata = ChatManager::getRoleDetail();
        $user_id = $userdata['user_id'];
        $user_role = $userdata['role'];

        $dataArray = $service->getImportquotationService($request,$user_id,$user_role);
        if (!$dataArray['status']) {
            toastr()->error($dataArray['message']);
            return back();
        }

        // $this->productRepo->addArray(data: $dataArray['products']);
        toastr()->success($dataArray['message']);
        return back();
    }

    public function index(){
        return view('web.postrfq');
    }

    public function getLeadsForBanner()
    {
        // Fetch 100 leads from the Leads model
        $lead = Leads::inRandomOrder()->first();

        // Return the leads as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $lead,
        ]);
    }
}
