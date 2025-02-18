<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AgrotradexController extends Controller
{
    public function index(){
        return view('web.agrotradex');
    }

    public function updatepolicyaccept(Request $request){
        $id = $request->user;
        $getuser = User::where('id',$id)->first();
        $getuser->terms_accepted = 1;
        $getuser->save();

        toastr()->success('Terms Successfully Accepted');
        return redirect()->back()->with("success","Terms Successfully Accepted");
    }

    public function getpolicyaccept(Request $request){
        $id = $request->id;
        $getuser = User::where('id',$id)->first();
        $getuser->terms_accepted = 1;
        $getuser->save();

        toastr()->success('Terms Successfully Accepted');
        return redirect()->back()->with("success","Terms Successfully Accepted");
    }
}
