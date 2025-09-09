<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Kepsek;

class KepsekDashboardController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahStaff = Staff::count();
        $jumlahAdmin = Admin::count();

        return view('kepsek-dashboard', compact('jumlahUser', 'jumlahStaff', 'jumlahAdmin'));
    }
}
