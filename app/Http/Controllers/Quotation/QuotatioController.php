<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\QuotationService;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\User;
use App\Models\Category;
use App\Models\Leads;
use Brian2694\Toastr\Toastr;
use App\Utils\ChatManager;
use App\Utils\EmailHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuotatioController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_name' => 'required|max:255',
            'category' => 'required',
            'purchase_quantity' => 'required',
            'unit_unit' => 'required',
            'target_unit_price' => 'required',
            'target_unit_price_currency' => 'required',
            'trade_terms' => 'required',
            'max_budget' => 'nullable',
            'max_budget_currency' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'details' => 'required',
            'contact_number' => 'required',
            'shipping_method' => 'required',
            'destination_port' => 'required',
            'destination_port_currency' => 'nullable',
            'spin_time' => 'required',
            'terms' => 'required',
        ]);

        // Get the user and role details
        $userdata = ChatManager::getRoleDetail();
        $userId = $userdata['user_id'] ?? '1';
        $role = $userdata['role'] ?? 'admin';


        $data = [
            'name' => $request->input('product_name'),
            'industry' => $request->input('category'),
            'quantity' => $request->input('purchase_quantity'),
            'unit' => $request->input('unit_unit'),
            'user_id' => $userId,
            'role' => $role,
            'target_unit_price' => $request->input('target_unit_price'),
            'target_unit_price_currency' => $request->input('target_unit_price_currency'),
            'term' => $request->input('trade_terms'),
            'max_budget' => $request->input('max_budget'),
            'max_budget_currency' => $request->input('max_budget_currency'),
            'image' => $request->file('image'),
            'description' => $request->input('details'),
            'pnumber' => $request->input('contact_number'),
            'shipping_method' => $request->input('shipping_method'),
            'destination_port' => $request->input('destination_port'),
            'destination_port_currency' => $request->input('destination_port_currency'),
            'spin_time' => $request->input('spin_time'),
            'terms' => $request->input('terms'),
        ];

        // Handle the Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/quotation');
            $image->move($path, $filename);
            $data['image'] = 'uploads/quotation/' . $filename;
        } else {
            return redirect()->back()->with('error', 'Image upload failed.');
        }

        // Create a new Quotation entry
        $quotation = Quotation::create($data);

        ChatManager::sendNotification([
            'sender_id'      => $quotation['user_id'],
            'receiver_id'    => $quotation['user_id'],
            'receiver_type'  => $quotation['role'],
            'type'           => 'quotation',
            'stocksell_id'   => null,
            'leads_id'       => null,
            'suppliers_id'   => null,
            'product_id'     => null,
            'product_qty'    => null,
            'title'          => 'New RFQ received',
            'message'        => Str::limit($quotation['description'], 100),
            'priority'       => 'normal',
            'action_url'     => 'quotation',
        ]);

        $user = Admin::find(1);
        $response = EmailHelper::sendInquiryMail($user);

        if (!$response['success']) {
            Log::error('Email Notification creation', [
                'error'     => $response['message'] ?? 'Unknown error',
            ]);
        }

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

        if ($request->filled('searchValue')) {
            $query->where('name', 'LIKE', '%' . $request->searchValue . '%');
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59',
            ]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
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

        $dataArray = $service->getImportquotationService($request, $user_id, $user_role);
        if (!$dataArray['status']) {
            toastr()->error($dataArray['message']);
            return back();
        }

        // $this->productRepo->addArray(data: $dataArray['products']);
        toastr()->success($dataArray['message']);
        return back();
    }

    public function index()
    {
        $data['categories'] = Category::all();
        return view('web.postrfq', $data);
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
