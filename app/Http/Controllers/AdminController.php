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

    // -------------------------- User Management Section -------------------------- //
    public function userManagement()
    {
        $users = \App\Models\User::all(); // ดึงข้อมูลผู้ใช้ทั้งหมด
        return view('admin.userManage.userManagement', compact('users'));
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.userManage.editUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id . ',user_id',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->only('firstname', 'lastname', 'username', 'email', 'phone', 'role'));

        return redirect()->route('admin.userManagement')->with('success', 'อัพเดทข้อมูลผู้ใช้เรียบร้อยแล้ว');
    }
    
    public function resetPassword($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->password_hash = \Hash::make('12345678'); 
        $user->save();

        return redirect()->route('admin.userManagement')->with('success', 'รีเซ็ตรหัสผ่านเป็น "12345678" แล้ว');
    }

    public function rooms()
    {
        // เรียกไฟล์ view/admin/rooms.blade.php
        return view('admin.rooms');
    }
    public function promotions()
    {
        // เรียกไฟล์ view/admin/promotions.blade.php
        return view('admin.promotions');
    }
    public function instruments()
    {
        // เรียกไฟล์ view/admin/instruments.blade.php
        return view('admin.instruments');
    }
    public function log()
    {
        // เรียกไฟล์ view/admin/log.blade.php
        return view('admin.log');
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
        if ($request->new_password) {
            if (Hash::check($request->current_password, $admin->password_hash)) {
                $admin->password_hash = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
            }
        }

        $admin->save();

        return back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
