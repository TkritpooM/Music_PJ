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
                <input type="datetime-local" name="start_time" class="form-control">
            </div>
            <div class="col-md-6">
                <label>End Time</label>
                <input type="datetime-local" name="end_time" class="form-control">
            </div>
        </div>
        <button type="button" id="checkBtn" class="btn btn-primary">Check Availability</button>
    </form>

    <div id="priceResult" class="mt-4"></div>
</div>

<script>
document.getElementById('checkBtn').addEventListener('click', function() {
    const form = document.getElementById('availabilityForm');
    const startInput = form.querySelector('[name="start_time"]');
    const endInput = form.querySelector('[name="end_time"]');

    if (!startInput.value || !endInput.value) {
        alert('กรุณาเลือก Start และ End time');
        return;
    }

    // สร้าง Date objects (datetime-local เป็น local ISO without timezone)
    const start = new Date(startInput.value);
    let end = new Date(endInput.value);

    // ถ้า end <= start ให้สมมติว่าเป็นวันถัดไป (midnight เป็นต้น)
    if (end <= start) {
        end.setDate(end.getDate() + 1);

        // อัปเดต input ให้ผู้ใช้เห็นการเปลี่ยนแปลง
        const pad = n => n.toString().padStart(2, '0');
        const formatted = end.getFullYear() + '-' + pad(end.getMonth()+1) + '-' + pad(end.getDate())
            + 'T' + pad(end.getHours()) + ':' + pad(end.getMinutes());
        endInput.value = formatted;
    }

    // สร้าง FormData ส่งไป
    const data = new FormData();
    data.append('_token', '{{ csrf_token() }}');
    data.append('start_time', startInput.value);
    data.append('end_time', endInput.value);

    fetch("{{ route('user.room.checkAvailability', $room->room_id) }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: data
    })
    .then(async res => {
        if (!res.ok) {
            if (res.status === 422) {
                const json = await res.json();
                const messages = Object.values(json.errors || {}).flat().join('\n');
                alert(messages || 'ข้อมูลไม่ถูกต้อง');
                return null;
            }
            throw new Error('Network error');
        }
        return res.json();
    })
    .then(data => {
        if (!data) return;
        if (data.conflict) {
            alert("❌ ห้องนี้ถูกจองแล้วในช่วงเวลาที่เลือก");
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
        alert('เกิดข้อผิดพลาด โปรดลองอีกครั้ง');
    });
});
</script>
@endsection
