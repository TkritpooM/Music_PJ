<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // เรียกไฟล์ view/admin/dashboard.blade.php
        return view('admin.dashboard');
    }
}
