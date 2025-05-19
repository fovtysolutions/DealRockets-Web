<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\TableJobProfile;
use Illuminate\Support\Str;

class TalentfinderController extends Controller
{
    public function webindex(Request $request)
    {
        $name = $request->talentfinder;
        $category = $request->categoryid;

        $talentfinderQuery = TableJobProfile::query();

        if ($name) {
            $talentfinderQuery->where('full_name', 'like', '%' . $name . '%');
        }

        $data['items'] = $talentfinderQuery->paginate(9);

        // Filters Data
        $data['currencies'] = TableJobProfile::distinct()->pluck('currency');
        $data['keywords'] = TableJobProfile::pluck('skills')
            ->filter()
            ->flatMap(function ($item) {
                // Remove surrounding brackets or quotes from malformed JSON-like strings
                $cleaned = str_replace(['[', ']', '"'], '', $item);
                return explode(',', $cleaned);
            })
            ->map(function ($item) {
                $label = trim($item);
                return [
                    'label' => $label,
                    'slug'  => Str::slug($label),
                ];
            })
            ->filter(fn($item) => $item['label'] !== '')
            ->unique('slug')
            ->values();
        $data['countries'] = Country::all();
        $data['jobtitle'] = TableJobProfile::distinct()->pluck('desired_position');
        if (Auth('customer')->check()) {
            $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
            if (isset($membership['error'])) {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
            }
        } else {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Avaliable'];
        }
        $data['membership'] = $membership;
        return view('web.talentfinder', $data);
    }

    public function get_dynamic_data(Request $request)
    {
        $query = TableJobProfile::query();

        // Text Search (search_filter)
        if ($request->filled('search_filter')) {
            $query->where('name', 'like', '%' . $request->search_filter . '%');
        }

        // Salary Range
        if ($request->filled('min_salary') && $request->filled('max_salary')) {
            $query->whereBetween('desired_salary', [
                (int) $request->min_salary,
                (int) $request->max_salary
            ]);
        }

        // Currency Filter
        if ($request->filled('currency')) {
            $query->whereIn('currency', $request->currency);
        }

        // Keywords (skills)
        if ($request->filled('keywords')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->keywords as $keyword) {
                    $q->orWhere('skills', 'LIKE', '%' . $keyword . '%');
                }
            });
        }

        // Job Titles
        if ($request->filled('jobtitle')) {
            $query->whereIn('desired_position', $request->jobtitle);
        }

        if ($request->filled('job_types')){
            $query->whereIn('employment_type', $request->job_types);
        }

        // Countries
        if ($request->filled('locations')) {
            $query->whereIn('country', $request->locations);
        }

        $page = $request->get('page', 1);

        // Paginate the filtered results
        $items = $query->paginate(6, ['*'], 'page', $page);
        if (Auth('customer')->check()) {
            $membership = \App\Utils\ChatManager::getMembershipStatusCustomer(Auth('customer')->user()->id);
            if (isset($membership['error'])) {
                $membership = ['status' => 'NotMade', 'message' => 'Membership Not Applied'];
            }
        } else {
            $membership = ['status' => 'NotMade', 'message' => 'Membership Not Avaliable'];
        }
        // AJAX or normal?
        if ($request->ajax()) {
            $html = view('web.dynamic-partials.dynamic-talentfinder', compact('items','membership'))->render();
            $mobhtml = view('web.dynamic-partials.dynamic-mobtalentfinder', compact('items','membership'))->render();
            $pagination = $items->links('custom-paginator.custom')->render();

            return response()->json([
                'html' => $html,
                'mobhtml' => $mobhtml,
                'pagination' => $pagination,
            ]);
        }

        $html = view('web.dynamic-partials.dynamic-talentfinder', compact('items','membership'))->render();
        $mobhtml = view('web.dynamic-partials.dynamic-mobtalentfinder', compact('items','membership'))->render();
        $pagination = $items->links('custom-paginator.custom')->render();

        return response()->json([
            'html' => $html,
            'mobhtml' => $mobhtml,
            'pagination' => $pagination,
        ]);
    }

    public function get_data_candidate(Request $request)
    {
        $candidateid = $request->id;
        if ($candidateid) {
            $candetails = TableJobProfile::where('id', $candidateid)->first();
            $candetails['skills'] = implode(',', json_decode($candetails['skills'], true));
            $candetails['languages'] = implode(',', json_decode($candetails['languages'], true));
        }
        return response()->json($candetails);
    }
}
