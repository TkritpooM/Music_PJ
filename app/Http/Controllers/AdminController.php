<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Promotion;
use App\Models\Room;
use App\Models\InstrumentCategory;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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

    // -------------------------- Rooms Section -------------------------- //

    // Rooms
    public function rooms()
    {
        $rooms = Room::all();
        return view('admin.roomManage.rooms', compact('rooms'));
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100|unique:rooms,name',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity'       => 'required|integer|min:1',
            'description'    => 'nullable|string|max:500',
            'image_url'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
        ], [
            'name.required'           => 'กรุณากรอกชื่อห้อง',
            'name.max'                => 'ชื่อห้องต้องไม่เกิน 100 ตัวอักษร',
            'name.unique'             => 'ชื่อห้องนี้มีอยู่แล้ว โปรดเปลี่ยนชื่อ',
            'price_per_hour.required' => 'กรุณากรอกราคาต่อชั่วโมง',
            'price_per_hour.numeric'  => 'ราคาต้องเป็นตัวเลข',
            'price_per_hour.min'      => 'ราคาต้องไม่น้อยกว่า 0',
            'capacity.required'       => 'กรุณากรอกจำนวนผู้ใช้สูงสุด',
            'capacity.integer'        => 'จำนวนผู้ใช้ต้องเป็นจำนวนเต็ม',
            'capacity.min'            => 'จำนวนผู้ใช้ต้องไม่น้อยกว่า 1',
            'description.string'      => 'คำอธิบายต้องเป็นข้อความ',
            'description.max'         => 'คำอธิบายต้องไม่เกิน 500 ตัวอักษร',
            'image_url.image'         => 'ไฟล์ต้องเป็นรูปภาพ',
            'image_url.mimes'         => 'ไฟล์รูปภาพต้องเป็น jpg, jpeg หรือ png',
            'image_url.max'           => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 5MB',
        ]);

        $data = $request->only('name', 'price_per_hour', 'capacity', 'description');

        // ถ้ามีการอัปโหลดรูป
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('rooms', 'public');
            $data['image_url'] = $path;
        }

        Room::create($data);

        return redirect()->route('admin.rooms')->with('success', 'เพิ่มห้องซ้อมเรียบร้อยแล้ว');
    }

    public function editRoom($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.roomManage.editRoom', compact('room'));
    }

    public function updateRoom(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:100',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity'       => 'required|integer|min:1',
            'description'    => 'nullable|string',
            'image_url'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only('name', 'price_per_hour', 'capacity', 'description');

        // ถ้ามีการอัปโหลดรูปใหม่
        if ($request->hasFile('image_url')) {
            // ลบไฟล์เก่าออกก่อน (ถ้ามี)
            if ($room->image_url && Storage::disk('public')->exists($room->image_url)) {
                Storage::disk('public')->delete($room->image_url);
            }
            $path = $request->file('image_url')->store('rooms', 'public');
            $data['image_url'] = $path;
        }

        $room->update($data);

        return redirect()->route('admin.rooms')->with('success', 'แก้ไขข้อมูลห้องเรียบร้อยแล้ว');
    }

    public function deleteRoom($id)
    {
        $room = Room::findOrFail($id);

        // ลบไฟล์รูปออกด้วย
        if ($room->image_url && Storage::disk('public')->exists($room->image_url)) {
            Storage::disk('public')->delete($room->image_url);
        }

        $room->delete();

        return redirect()->route('admin.rooms')->with('success', 'ลบห้องเรียบร้อยแล้ว');
    }

    // Adding Instrument to Rooms
    // แสดงเครื่องดนตรีทั้งหมดในห้อง
    public function showRoomInstruments($roomId)
    {
        $room = Room::with('instruments')->findOrFail($roomId);
        $instruments = Instrument::all(); // สำหรับเลือกเพิ่มใหม่
        return view('admin.roomManage.room_instruments', compact('room', 'instruments'));
    }

    // เพิ่มเครื่องดนตรีให้ห้อง
    public function addInstrumentToRoom(Request $request, $roomId)
    {
        $request->validate([
            'instrument_id' => 'required|exists:instruments,instrument_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($roomId);

        // ตรวจสอบ duplicate
        if ($room->instruments()->where('room_instruments.instrument_id', $request->instrument_id)->exists()) {
            return redirect()->back()->withErrors(['duplicate' => 'เครื่องดนตรีนี้มีอยู่ในห้องแล้ว']);
        }

        // เพิ่ม pivot table
        $room->instruments()->attach($request->instrument_id, ['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'เพิ่มเครื่องดนตรีให้ห้องเรียบร้อยแล้ว');
    }

    // อัปเดตจำนวนเครื่องดนตรีในห้อง
    public function updateRoomInstrument(Request $request, $roomId, $instrumentId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($roomId);
        $room->instruments()->updateExistingPivot($instrumentId, [
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'อัปเดตจำนวนเครื่องดนตรีเรียบร้อยแล้ว');
    }

    // ลบเครื่องดนตรีออกจากห้อง
    public function detachInstrumentFromRoom($roomId, $instrumentId)
    {
        $room = Room::findOrFail($roomId);
        $room->instruments()->detach($instrumentId);

        return back()->with('success', 'ลบเครื่องดนตรีออกจากห้องเรียบร้อยแล้ว');
    }

    // -------------------------- Promotions Section -------------------------- //
    public function promotions()
    {
        $promotions = Promotion::orderBy('start_date', 'desc')->get();
        return view('admin.promotionManage.promotions', compact('promotions'));
    }

    public function createPromotion()
    {
        return view('admin.promotionManage.createPromotion'); // หน้าเพิ่มโปรโมชั่น
    }

    public function storePromotion(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:promotions,name',
            'description' => 'nullable|string|max:500',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => ['required','numeric','min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percent' && $value > 100) {
                        $fail('ส่วนลดแบบเปอร์เซ็นต์ต้องไม่เกิน 100');
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'name.required' => 'กรุณากรอกชื่อโปรโมชั่น',
            'name.max' => 'ชื่อโปรโมชั่นต้องไม่เกิน 100 ตัวอักษร',
            'name.unique' => 'ชื่อโปรโมชั่นนี้มีอยู่แล้ว',
            'description.string' => 'คำอธิบายต้องเป็นข้อความ',
            'description.max' => 'คำอธิบายต้องไม่เกิน 500 ตัวอักษร',
            'discount_type.required' => 'กรุณาเลือกประเภทส่วนลด',
            'discount_type.in' => 'ประเภทส่วนลดต้องเป็น percent หรือ fixed',
            'discount_value.required' => 'กรุณากรอกจำนวนส่วนลด',
            'discount_value.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'discount_value.min' => 'จำนวนส่วนลดต้องไม่น้อยกว่า 0',
            'start_date.required' => 'กรุณาเลือกวันเริ่มต้นโปรโมชั่น',
            'start_date.date' => 'วันเริ่มต้นไม่ถูกต้อง',
            'end_date.required' => 'กรุณาเลือกวันสิ้นสุดโปรโมชั่น',
            'end_date.date' => 'วันสิ้นสุดไม่ถูกต้อง',
            'end_date.after_or_equal' => 'วันสิ้นสุดต้องไม่ก่อนวันเริ่มต้น',
        ]);

        Promotion::create([
            'name' => $request->name,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
        ]);

        return redirect()->route('admin.promotions')->with('success', 'เพิ่มโปรโมชั่นเรียบร้อยแล้ว');
    }

    public function editPromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotionManage.editPromotion', compact('promotion'));
    }

    public function updatePromotion(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:promotions,name,' . $id . ',promo_id',
            'description' => 'nullable|string|max:500',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => ['required','numeric','min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percent' && $value > 100) {
                        $fail('ส่วนลดแบบเปอร์เซ็นต์ต้องไม่เกิน 100');
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'กรุณากรอกชื่อโปรโมชั่น',
            'name.max' => 'ชื่อโปรโมชั่นต้องไม่เกิน 100 ตัวอักษร',
            'name.unique' => 'ชื่อโปรโมชั่นนี้มีอยู่แล้ว',
            'description.string' => 'คำอธิบายต้องเป็นข้อความ',
            'description.max' => 'คำอธิบายต้องไม่เกิน 500 ตัวอักษร',
            'discount_type.required' => 'กรุณาเลือกประเภทส่วนลด',
            'discount_type.in' => 'ประเภทส่วนลดต้องเป็น percent หรือ fixed',
            'discount_value.required' => 'กรุณากรอกจำนวนส่วนลด',
            'discount_value.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'discount_value.min' => 'จำนวนส่วนลดต้องไม่น้อยกว่า 0',
            'start_date.required' => 'กรุณาเลือกวันเริ่มต้นโปรโมชั่น',
            'start_date.date' => 'วันเริ่มต้นไม่ถูกต้อง',
            'end_date.required' => 'กรุณาเลือกวันสิ้นสุดโปรโมชั่น',
            'end_date.date' => 'วันสิ้นสุดไม่ถูกต้อง',
            'end_date.after_or_equal' => 'วันสิ้นสุดต้องไม่ก่อนวันเริ่มต้น',
        ]);

        $promotion->update([
            'name' => $request->name,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.promotions')->with('success', 'แก้ไขโปรโมชั่นเรียบร้อยแล้ว');
    }

    public function deletePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return redirect()->route('admin.promotions')->with('success', 'ลบโปรโมชั่นเรียบร้อยแล้ว');
    }

    public function togglePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        return redirect()->route('admin.promotions')->with('success', 'อัปเดตสถานะโปรโมชั่นเรียบร้อยแล้ว');
    }

    // -------------------------- Instruments Section -------------------------- //

    // Instruments Category
    public function instrumentCategories()
    {
        $categories = InstrumentCategory::all();
        return view('admin.instrumentManage.instrument_categories', compact('categories'));
    }

    public function storeInstrumentCategory(Request $request)
    {
        // ตัดช่องว่างก่อน validate
        $name = trim($request->name);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('instrument_categories')->where(function ($query) use ($name) {
                    return $query->whereRaw('LOWER(name) = ?', [Str::lower($name)]);
                }),
            ],
        ], [
            'name.required' => 'กรุณากรอกชื่อประเภทเครื่องดนตรี',
            'name.string'   => 'ชื่อประเภทเครื่องดนตรีต้องเป็นข้อความ',
            'name.max'      => 'ชื่อประเภทเครื่องดนตรีต้องไม่เกิน 100 ตัวอักษร',
            'name.unique'   => 'ประเภทเครื่องดนตรีนี้มีอยู่แล้ว',
        ]);

        InstrumentCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.instrumentCategories')->with('success', 'เพิ่มประเภทเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function deleteSelectedInstrumentCategories(Request $request)
    {
        $ids = $request->ids;
        if(!$ids || !is_array($ids)){
            return response()->json(['success' => false]);
        }

        // ลบเครื่องดนตรีใน category ที่เลือกด้วย (ถ้ามี)
        \App\Models\Instrument::whereIn('category_id', $ids)->delete();

        // ลบ category
        InstrumentCategory::whereIn('category_id', $ids)->delete();

        return response()->json(['success' => true]);
    }

    // Instruments By Category
    public function instrumentsByCategory($category_id)
    {
        $category = InstrumentCategory::findOrFail($category_id);
        $instruments = Instrument::where('category_id', $category_id)->get();
        return view('admin.instrumentManage.instruments', compact('category', 'instruments'));
    }

    public function storeInstrument(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:instrument_categories,category_id',
            'code' => 'required|string|max:20|unique:instruments,code',
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:available,unavailable,maintenance',
        ], [
            'category_id.required' => 'กรุณาเลือกประเภทเครื่องดนตรี',
            'category_id.exists' => 'ประเภทเครื่องดนตรีไม่ถูกต้อง',
            'code.required' => 'กรุณากรอกรหัสเครื่องดนตรี',
            'code.unique' => 'รหัสเครื่องดนตรีนี้มีอยู่แล้ว',
            'name.required' => 'กรุณากรอกชื่อเครื่องดนตรี',
            'status.required' => 'กรุณาเลือกสถานะเครื่องดนตรี',
            'status.in' => 'สถานะเครื่องดนตรีไม่ถูกต้อง',
            'picture_url.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'picture_url.mimes' => 'รองรับเฉพาะไฟล์ jpg/jpeg/png',
            'picture_url.max' => 'ไฟล์รูปภาพไม่เกิน 5MB',
        ]);

        $data = $request->only('category_id','code','name','brand','status');

        if ($request->hasFile('picture_url')) {
            $path = $request->file('picture_url')->store('instruments', 'public');
            $data['picture_url'] = $path;
        }

        Instrument::create($data);

        return back()->with('success', 'เพิ่มเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function updateInstrument(Request $request, $id)
    {
        $instrument = Instrument::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:available,unavailable,maintenance',
        ], [
            'name.required' => 'กรุณากรอกชื่อเครื่องดนตรี',
            'status.required' => 'กรุณาเลือกสถานะเครื่องดนตรี',
            'status.in' => 'สถานะเครื่องดนตรีไม่ถูกต้อง',
            'picture_url.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'picture_url.mimes' => 'รองรับเฉพาะไฟล์ jpg/jpeg/png',
            'picture_url.max' => 'ไฟล์รูปภาพไม่เกิน 5MB',
        ]);

        $data = $request->only('name','brand','status');

        if ($request->hasFile('picture_url')) {
            if ($instrument->picture_url && Storage::disk('public')->exists($instrument->picture_url)) {
                Storage::disk('public')->delete($instrument->picture_url);
            }
            $path = $request->file('picture_url')->store('instruments', 'public');
            $data['picture_url'] = $path;
        }

        $instrument->update($data);

        return back()->with('success', 'แก้ไขข้อมูลเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function deleteInstrument($id)
    {
        $instrument = Instrument::findOrFail($id);

        if ($instrument->picture_url && Storage::disk('public')->exists($instrument->picture_url)) {
            Storage::disk('public')->delete($instrument->picture_url);
        }

        $instrument->delete();

        return back()->with('success', 'ลบเครื่องดนตรีเรียบร้อยแล้ว');
    }

    // Rooms used by instrument
    public function showInstrument($id)
    {
        $instrument = Instrument::with('rooms')->findOrFail($id);
        return view('admin.instrumentManage.show', compact('instrument'));
    }

    public function addRoomToInstrument($instrumentId)
    {
        $instrument = Instrument::findOrFail($instrumentId);
        $rooms = Room::all(); // เลือกได้ทั้งหมด หรือจะกรองตามเงื่อนไข
        return view('admin.instrumentManage.addRoom', compact('instrument', 'rooms'));
    }

    public function storeInstrumentRoom(Request $request, $instrumentId)
    {
        $instrument = Instrument::findOrFail($instrumentId);

        // ✅ ใส่ validation และเช็ค duplicate
        $request->validate([
            'room_id' => 'required|exists:rooms,room_id',
            'quantity' => 'required|integer|min:1',
        ], [
            'room_id.required' => 'กรุณาเลือกห้อง',
            'room_id.exists' => 'ห้องที่เลือกไม่ถูกต้อง',
            'quantity.required' => 'กรุณากรอกจำนวน',
            'quantity.min' => 'จำนวนต้องมากกว่า 0',
        ]);

        // ป้องกัน duplicate entry
        $exists = $instrument->rooms()->wherePivot('room_id', $request->room_id)->exists();
        if ($exists) {
            return back()
                ->withErrors(['room_id' => 'ห้องนี้มีอยู่แล้วสำหรับเครื่องดนตรีนี้'], 'instrumentRoom')
                ->withInput(['instrument_id' => $instrumentId, 'room_id' => $request->room_id, 'quantity' => $request->quantity]);
        }
        
        // หรือถ้า validation error จะถูก handle โดย Laravel อัตโนมัติ
        // ให้แน่ใจว่า old('instrument_id') ถูกตั้ง
        $request->merge(['instrument_id' => $instrumentId]);

        // เพิ่มห้องให้เครื่องดนตรี
        $instrument->rooms()->attach($request->room_id, ['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'เพิ่มห้องให้เครื่องดนตรีเรียบร้อยแล้ว');
    }

    // อัพเดทจำนวนเครื่องดนตรีใน pivot
    public function updateInstrumentRoom(Request $request, $instrumentId, $roomId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $instrument = Instrument::findOrFail($instrumentId);
        $instrument->rooms()->updateExistingPivot($roomId, [
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'อัปเดตจำนวนเรียบร้อยแล้ว ✅');
    }

    // ลบห้องออกจากเครื่องดนตรี
    public function detachRoom($instrumentId, $roomId)
    {
        $instrument = Instrument::findOrFail($instrumentId);
        $instrument->rooms()->detach($roomId);

        return back()->with('success', 'ลบห้องออกเรียบร้อยแล้ว ❌');
    }




    // -------------------------- Log Section -------------------------- //
    public function log()
    {
        // เรียกไฟล์ view/admin/log.blade.php
        return view('admin.log');
    }

    // -------------------------- Profile Setting Section -------------------------- //
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
