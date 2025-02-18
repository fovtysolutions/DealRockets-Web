<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TableJobProfile;

class TalentfinderController extends Controller
{
    public function webindex(Request $request){
        $name = $request->talentfinder;
        $category = $request->categoryid;

        $talentfinderQuery = TableJobProfile::query();

        if($name){
            $talentfinderQuery->where('full_name','like','%'.$name.'%');
        }

        $talentfinder = $talentfinderQuery->get();

        return view('web.talentfinder',compact('talentfinder'));
    }

    public function get_data_candidate(Request $request){
        $candidateid = $request->id;
        if($candidateid){
            $candetails = TableJobProfile::where('id',$candidateid)->first();
            $candetails['skills'] = implode(',',json_decode($candetails['skills'],true));
            $candetails['languages'] = implode(',',json_decode($candetails['languages'],true));
        }
        return response()->json($candetails);
    }
}
