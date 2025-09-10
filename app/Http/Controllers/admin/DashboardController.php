<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $data['header_title'] = "Dashboard";
        return view('admin.dashboard',$data);
    }

    public function adminList ()
    {
        $data['header_title'] = "Admin List";
        return view('admin.list',$data);
    }
}
