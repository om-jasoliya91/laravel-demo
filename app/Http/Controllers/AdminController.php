<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminDashboardView()
    {
        return view('admin/dashboard');
    }
}
