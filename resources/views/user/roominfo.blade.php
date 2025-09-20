@extends('layout.userlayout')

@section('title', 'Room Info')

@section('content')
<div class="container py-5">

    <!-- Card Glassmorphism -->
    <div class="glass-card p-4">
        <h2 class="fw-bold mb-3 text-dark">
            <i class="bi bi-music-note-beamed me-2"></i>{{ $room->name }}
        </h2>
        <p class="text-muted mb-1"><i class="bi bi-cash-coin me-2"></i>Price: {{ number_format($room->price_per_hour,2) }} ฿ / hour</p>
        <p class="text-muted"><i class="bi bi-people-fill me-2"></i>Capacity: {{ $room->capacity }}</p>

        <!-- ตารางเวลาที่ถูกจอง -->
        <h5 class="text-dark mt-4">
            <i class="bi bi-calendar-event me-2"></i>Existing Bookings
        </h5>
        <div id="calendar" class="glass-calendar p-3 rounded mb-4"></div>

        <!-- ฟอร์มเลือกวันเวลา -->
        <form id="availabilityForm" class="glass-form p-3 rounded">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label text-dark"><i class="bi bi-clock me-1"></i>Start Time</label>
                    <input type="datetime-local" name="start_time" class="form-control bg-white text-dark border-0 shadow-sm" step="3600">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-dark"><i class="bi bi-clock-history me-1"></i>End Time</label>
                    <input type="datetime-local" name="end_time" class="form-control bg-white text-dark border-0 shadow-sm" step="3600">
                </div>
            </div>
            <button type="button" id="checkBtn" class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i>Check Availability
            </button>
        </form>

        <div id="priceResult" class="mt-4 text-dark"></div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* Base */
body {
    background: #f9f9fb;
    min-height: 100vh;
    font-family: "Inter", sans-serif;
}

/* Glassmorphism Layer */
.glass-card {
    background: rgba(255, 255, 255, 0.7);
    border-radius: 16px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(200, 200, 200, 0.3);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}
.glass-form {
    background: rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(200, 200, 200, 0.2);
}
.glass-calendar {
    background: rgba(255, 255, 255, 0.6);
    border-radius: 12px;
    border: 1px solid rgba(200, 200, 200, 0.2);
}

/* Calendar */
.fc-toolbar-title {
    color: #333 !important;
    font-weight: 600;
}
.fc-col-header-cell-cushion,
.fc-daygrid-day-number {
    color: #333 !important;
    font-weight: 500;
}
.fc-event {
    border-radius: 6px !important;
    font-size: 0.8rem;
    padding: 2px 6px;
}

/* Button */
.btn-primary {
    background: linear-gradient(135deg, #4a90e2, #67aaf9);
    border: none;
    border-radius: 8px;
    font-weight: 500;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
}

/* Price Box */
#priceResult .glass-form {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(200, 200, 200, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    // ส่ง $bookings ไป JSON ตรง ๆ
    const rawBookings = @json($bookings);

    const calendarEvents = rawBookings.map(b => ({
        title: 'Booked',
        start: b.start_time,
        end: b.end_time,
        color: '#e74c3c'
    }));

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: calendarEvents,
        selectable: false,
        dayMaxEventRows: true,
        dayMaxEvents: 3,
    });

    calendar.render();

    // ------------------------------------------------------------------- //

    const startInput = document.querySelector('[name="start_time"]');
    const endInput = document.querySelector('[name="end_time"]');

    const SwalDefault = Swal.mixin({
        scrollbarPadding: false,
        heightAuto: false
    });

    startInput.step = 3600;
    endInput.step = 3600;

    const formatDateTime = (d) => {
        const pad = (n) => n.toString().padStart(2, '0');
        return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate())
            + 'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
    };

    const now = new Date();
    if (now.getMinutes() > 0 || now.getSeconds() > 0) {
        now.setHours(now.getHours() + 1, 0, 0, 0);
    } else {
        now.setMinutes(0,0,0);
    }
    startInput.min = formatDateTime(now);
    startInput.value = formatDateTime(now);

    const defaultEnd = new Date(now.getTime() + 60*60*1000);
    defaultEnd.setMinutes(0,0,0);
    endInput.min = formatDateTime(defaultEnd);
    endInput.value = formatDateTime(defaultEnd);

    const bookings = @json($bookings->map(function($b) {
        return [
            'start' => $b->start_time,
            'end' => $b->end_time
        ];
    })->toArray());

    startInput.addEventListener('change', function () {
        if (!startInput.value) return;
        const start = new Date(startInput.value);
        start.setMinutes(0,0,0);
        startInput.value = formatDateTime(start);

        const minEnd = new Date(start.getTime() + 60*60*1000);
        minEnd.setMinutes(0,0,0);

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

        if (start < now || (start.getHours() === 0 && start.getMinutes() === 0)) {
            SwalDefault.fire({
                icon: 'warning',
                title: 'เวลาไม่ถูกต้อง',
                text: 'ไม่สามารถเลือกเวลาที่ผ่านมาแล้วได้ ระบบจะปรับเป็นเวลาถัดไปอัตโนมัติ'
            });

            start.setDate(now.getDate() + 1);
            start.setHours(0,0,0,0);
            startInput.value = formatDateTime(start);
        }

        if (end <= start) {
            end = new Date(start.getTime() + 60*60*1000);
            endInput.value = formatDateTime(end);
        }

        if (end < new Date(start.getTime() + 60*60*1000)) {
            SwalDefault.fire({
                icon: 'warning',
                title: 'End time ไม่ถูกต้อง',
                text: 'End time ต้องอย่างน้อย 1 ชั่วโมงหลัง Start time'
            });
            return;
        }

        const conflict = bookings.some(b => {
            const bStart = new Date(b.start);
            const bEnd = new Date(b.end);
            return start < bEnd && end > bStart;
        });

        if (conflict) {
            SwalDefault.fire({
                icon: 'error',
                title: 'ห้องไม่ว่าง',
                text: 'ห้องนี้ถูกจองแล้วในช่วงเวลาที่เลือก'
            });
            return;
        }

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
                    title: 'ห้องไม่ว่าง',
                    text: 'ห้องนี้ถูกจองแล้วในช่วงเวลาที่เลือก'
                });
            } else {
                document.getElementById('priceResult').innerHTML = `
                    <div class="glass-form p-3 rounded mt-3">
                        <p><i class="bi bi-hourglass-split me-2"></i>Hours: ${data.hours}</p>
                        <p><i class="bi bi-cash me-2"></i>Price: ${data.price} ฿</p>
                        <p><i class="bi bi-percent me-2"></i>Discount: ${Number(data.discount).toFixed(2)} ฿</p>
                        <p><i class="bi bi-check-circle me-2"></i><strong>Total: ${Number(data.total).toFixed(2)} ฿</strong></p>
                        <a href="{{ route('user.room.addons', $room->room_id) }}?hours=${data.hours}&total=${data.total}&start_time=${encodeURIComponent(startInput.value)}&end_time=${encodeURIComponent(endInput.value)}" 
                           class="btn btn-success w-100 mt-2">
                            Next → Add-ons
                        </a>
                    </div>
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
