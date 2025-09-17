@extends('layout.userlayout')

@section('title', 'Room Info')

@section('content')
<div class="container py-5">
    <h2 class="mb-3">{{ $room->name }}</h2>
    <p>Price: {{ number_format($room->price_per_hour,2) }} ฿ / hour</p>
    <p>Capacity: {{ $room->capacity }}</p>

    <!-- ตารางเวลาที่ถูกจอง -->
    <h5 class="mt-4">Existing Bookings</h5>
    <ul>
        @foreach($bookings as $b)
            <li>
                {{ \Carbon\Carbon::parse($b->start_time)->format('d/m/Y H:i') }} → 
                {{ \Carbon\Carbon::parse($b->end_time)->format('d/m/Y H:i') }}
            </li>
        @endforeach
    </ul>

    <!-- ฟอร์มเลือกวันเวลา -->
    <form id="availabilityForm">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" step="3600">
            </div>
            <div class="col-md-6">
                <label>End Time</label>
                <input type="datetime-local" name="end_time" class="form-control" step="3600">
            </div>
        </div>
        <button type="button" id="checkBtn" class="btn btn-primary">Check Availability</button>
    </form>

    <div id="priceResult" class="mt-4"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const startInput = document.querySelector('[name="start_time"]');
    const endInput = document.querySelector('[name="end_time"]');

    // ✅ กำหนดค่า default ของ SweetAlert2
    const SwalDefault = Swal.mixin({
        scrollbarPadding: false,
        heightAuto: false
    });

    // step=3600 ให้เลือกได้เฉพาะชั่วโมง
    startInput.step = 3600;
    endInput.step = 3600;

    // ฟังก์ชัน format วันที่ให้เป็น yyyy-MM-ddTHH:mm
    const formatDateTime = (d) => {
        const pad = (n) => n.toString().padStart(2, '0');
        return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate())
            + 'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
    };

    // กำหนดค่า default ของ Start Time (ปัดขึ้นชั่วโมงถัดไป)
    const now = new Date();
    if (now.getMinutes() > 0 || now.getSeconds() > 0) {
        now.setHours(now.getHours() + 1, 0, 0, 0);
    } else {
        now.setMinutes(0,0,0);
    }
    startInput.min = formatDateTime(now);
    startInput.value = formatDateTime(now);

    // กำหนดค่า default ของ End Time = Start + 1 ชั่วโมง
    const defaultEnd = new Date(now.getTime() + 60*60*1000);
    defaultEnd.setMinutes(0,0,0);
    endInput.min = formatDateTime(defaultEnd);
    endInput.value = formatDateTime(defaultEnd);

    // ส่ง bookings ปัจจุบันไป JS
    const bookings = @json($bookings->map(function($b) {
        return [
            'start' => $b->start_time,
            'end' => $b->end_time
        ];
    })->toArray());

    // อัปเดต min และ default ของ end ทุกครั้งที่ start เปลี่ยน
    startInput.addEventListener('change', function () {
        if (!startInput.value) return;
        const start = new Date(startInput.value);

        // นาทีล็อคเป็น 00
        start.setMinutes(0,0,0);
        startInput.value = formatDateTime(start);

        const minEnd = new Date(start.getTime() + 60*60*1000);
        minEnd.setMinutes(0,0,0);

        // ถ้า End <= Start ให้บวกวัน
        if (minEnd <= start) {
            minEnd.setDate(minEnd.getDate() + 1);
        }

        endInput.min = formatDateTime(minEnd);
        endInput.value = formatDateTime(minEnd);
    });

    document.getElementById('checkBtn').addEventListener('click', function() {
        let start = new Date(startInput.value);
        let end = new Date(endInput.value);
        const now = new Date();

        // ✅ ปัด start ถ้าเลือกเวลาที่ผ่านไปแล้ว หรือ 00:00 ของวันนี้
        if (start < now || (start.getHours() === 0 && start.getMinutes() === 0)) {
            start.setDate(now.getDate() + 1);
            start.setHours(0,0,0,0);
            startInput.value = formatDateTime(start);
        }

        // ✅ ปัด end ให้ start + 1 ชั่วโมง
        if (end <= start) {
            end = new Date(start.getTime() + 60*60*1000);
            endInput.value = formatDateTime(end);
        }

        // ตรวจสอบ end < start + 1 ชม.
        if (end < new Date(start.getTime() + 60*60*1000)) {
            SwalDefault.fire({
                icon: 'warning',
                title: '⛔ End time ไม่ถูกต้อง',
                text: 'End time ต้องอย่างน้อย 1 ชั่วโมงหลัง Start time'
            });
            return;
        }

        // ✅ ตรวจสอบ conflict กับ bookings ปัจจุบัน
        const conflict = bookings.some(b => {
            const bStart = new Date(b.start);
            const bEnd = new Date(b.end);
            return start < bEnd && end > bStart;
        });

        if (conflict) {
            SwalDefault.fire({
                icon: 'error',
                title: '❌ ห้องไม่ว่าง',
                text: 'ห้องนี้ถูกจองแล้วในช่วงเวลาที่เลือก'
            });
            return;
        }

        // ✅ ถ้าไม่มี conflict ส่ง fetch ไป backend
        const data = new FormData();
        data.append('_token', '{{ csrf_token() }}');
        data.append('start_time', startInput.value);
        data.append('end_time', endInput.value);

        fetch("{{ route('user.room.checkAvailability', $room->room_id) }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: data
        })
        .then(async res => {
            if (!res.ok) {
                if (res.status === 422) {
                    const json = await res.json();
                    const messages = Object.values(json.errors || {}).flat().join('\n');
                    SwalDefault.fire({
                        icon: 'error',
                        title: 'ข้อมูลไม่ถูกต้อง',
                        text: messages || 'โปรดตรวจสอบข้อมูลอีกครั้ง'
                    });
                    return null;
                }
                throw new Error('Network error');
            }
            return res.json();
        })
        .then(data => {
            if (!data) return;
            if (data.conflict) {
                SwalDefault.fire({
                    icon: 'error',
                    title: '❌ ห้องไม่ว่าง',
                    text: 'ห้องนี้ถูกจองแล้วในช่วงเวลาที่เลือก'
                });
            } else {
                document.getElementById('priceResult').innerHTML = `
                    <p>Hours: ${data.hours}</p>
                    <p>Price: ${data.price} ฿</p>
                    <p>Discount: ${Number(data.discount).toFixed(2)} ฿</p>
                    <p><strong>Total: ${Number(data.total).toFixed(2)} ฿</strong></p>
                    <a href="{{ route('user.room.addons', $room->room_id) }}?hours=${data.hours}&total=${data.total}&start_time=${encodeURIComponent(startInput.value)}&end_time=${encodeURIComponent(endInput.value)}" class="btn btn-success mt-2">Next → Add-ons</a>
                `;
            }
        })
        .catch(err => {
            console.error(err);
            SwalDefault.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'โปรดลองอีกครั้ง'
            });
        });
    });
});
</script>
@endsection
