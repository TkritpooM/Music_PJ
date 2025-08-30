<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // เรียกไฟล์ view/admin/dashboard.blade.php
        return view('admin.dashboard');
    }

    public function editProfile()
    {
        $admin = auth()->user(); // ตรวจสอบว่าเป็น admin ด้วย middleware
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $admin->user_id . ',user_id',
            'email' => 'required|email|unique:users,email,' . $admin->user_id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // อัพเดทข้อมูลทั่วไป
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->phone = $request->phone;

        // เปลี่ยนรหัสผ่านถ้ามี
        if($request->new_password){
            if(Hash::check($request->current_password, $admin->password_hash)){
                $admin->password_hash = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
            }
        }

        $admin->save();

        return back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
