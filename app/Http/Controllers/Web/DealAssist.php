<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\CategoryManager;

class DealAssist extends Controller
{
    public function index(){
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        return view('dealassist.index',compact('categories'));
    }
}
