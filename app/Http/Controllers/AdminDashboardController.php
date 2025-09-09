<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Staff;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahStaff = Staff::count();
        $jumlahAdmin = Admin::count();

        return view('admin-dashboard', compact('jumlahUser', 'jumlahStaff', 'jumlahAdmin'));
    }
}
