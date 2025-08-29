<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        // เรียกไฟล์ view/user/home.blade.php
        return view('user.home');
    }
}
