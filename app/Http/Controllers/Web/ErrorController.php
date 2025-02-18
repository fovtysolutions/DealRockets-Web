<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function error403(){
        return view('errors.403');
    }

    public function error401(){
        return view('errors.401');
    }

    public function error404(){
        return view('errors.404');
    }

    public function error419(){
        return view('errors.419');
    }
    
    public function error429(){
        return view('errors.429');
    }

    public function error500(){
        return view('errors.500');
    }

    public function error503(){
        return view('errors.503');
    }
}
