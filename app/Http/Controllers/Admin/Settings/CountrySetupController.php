<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Country; // Assuming you have a Country model
use Illuminate\Http\Request;

class CountrySetupController extends Controller
{
    // Display the list of countries
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get the search term from the request
        $blacklistFilter = $request->input('blacklist'); // Get the blacklist filter from the request
        $regionFilter = $request->input('region'); // Get the region filter from the request

        // Fetch countries based on the search term, blacklist filter, and region filter
        $countries = Country::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('phonecode', 'like', "%{$search}%");
            })
            ->when($blacklistFilter, function ($query, $blacklistFilter) {
                return $query->where('blacklist', $blacklistFilter);
            })
            ->when($regionFilter, function ($query, $regionFilter) {
                return $query->where('region', $regionFilter);
            })
            ->get();

        // Fetch unique regions for the filter dropdown
        $regions = Country::select('region')->distinct()->pluck('region');

        return view('admin-views.country-setup.index', compact('countries', 'search', 'blacklistFilter', 'regionFilter', 'regions'));
    }

    // Get the update view for a specific country
    public function getUpdateView($id)
    {
        $country = Country::findOrFail($id); // Find the country by ID
        return view('admin-views.country-setup.update', compact('country'));
    }

    // Update a specific country
    public function update(Request $request, $id)
    {
        $request->validate([
            'blacklist' => 'required',
        ]);

        $country = Country::findOrFail($id);
        $country->update($request->only(['blacklist']));

        return redirect()->route('admin.countrySetup.index')->with('success', 'Country updated successfully.');
    }

    // Update the status of a country (e.g., blacklist or active)
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:countries,id',
            'status' => 'required|in:active,blacklisted',
        ]);

        $country = Country::findOrFail($request->id);
        $country->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Country status updated successfully.']);
    }

    public static function getCountries()
    {
        return Country::where('blacklist','no')->get();
    }
}
