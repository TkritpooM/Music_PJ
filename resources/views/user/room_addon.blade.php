@extends('layout.userlayout')

@section('title', 'Room Add-On')

@section('content')
<div class="container py-5">

    <!-- Card Glassmorphism -->
    <div class="glass-card p-4">
        <h2 class="fw-bold mb-3 text-dark">
            <i class="bi bi-music-note-beamed me-2"></i>{{ $room->name }} - Add-ons
        </h2>

        <p class="text-muted mb-1">
            <i class="bi bi-clock me-1"></i>
            Duration: <strong>{{ $hours }} ชั่วโมง</strong>
            ({{ \Carbon\Carbon::parse($start_time)->format('d/m/Y H:i') }} - 
            {{ \Carbon\Carbon::parse($end_time)->format('d/m/Y H:i') }})
        </p>
        <p class="text-muted mb-3">
            <i class="bi bi-cash-coin me-1"></i>
            Base Price: <strong>{{ number_format($total,2) }} ฿</strong>
        </p>

        <form id="addonForm">
            @csrf
            <input type="hidden" name="base_total" value="{{ $total }}">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Instrument</th>
                            <th>Price / unit</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instruments as $inst)
                        <tr>
                            <td>
                                <img src="{{ $inst->picture_url ? asset('storage/' . $inst->picture_url) : 'https://shorturl.at/YT5O1' }}" 
                                        alt="{{ $inst->name }}" class="img-thumbnail addon-img" loading="lazy">
                            </td>
                            <td>{{ $inst->name }}</td>
                            <td>{{ number_format($inst->price_per_unit,2) }} ฿</td>
                            <td>
                                <input type="number" name="addons[{{ $inst->instrument_id }}][quantity]" value="0" min="0" 
                                    class="form-control addon-input" data-id="{{ $inst->instrument_id }}" data-price="{{ $inst->price_per_unit }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <div id="priceResult" class="mt-4 glass-form p-3 rounded">
            <p><i class="bi bi-cash me-1"></i>Add-on Total: 0 ฿</p>
            <p><i class="bi bi-check-circle me-1"></i><strong>Final Total: {{ number_format($total,2) }} ฿</strong></p>
        </div>

        <a href="{{ route('user.room.payment', [
                'room' => $room->room_id,
                'base_total' => $total,
                'addon_total' => 0,
                'final_total' => $total,
                'hours' => $hours,
                'start_time' => $start_time,
                'end_time' => $end_time
            ]) }}" 
        id="confirmBtn" class="btn btn-success w-100 mt-3">
            <i class="bi bi-credit-card me-1"></i>Confirm → Payment
        </a>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: #f9f9fb;
    min-height: 100vh;
    font-family: "Inter", sans-serif;
}

.addon-img {
    width: 80px;          /* กำหนดความกว้างเท่ากัน */
    height: 80px;         /* กำหนดความสูงเท่ากัน */
    object-fit: cover;    /* ครอปรูปให้เต็มกรอบโดยไม่บิด */
    border-radius: 8px;   /* ใส่โค้งมนเล็กน้อยถ้าต้องการ */
}

.glass-card {
    background: rgba(255, 255, 255, 0.75);
    border-radius: 16px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(200, 200, 200, 0.3);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.glass-form {
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid rgba(200, 200, 200, 0.25);
}

.table th, .table td {
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.03);
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #5cd65c);
    border: none;
    border-radius: 8px;
    font-weight: 500;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
}
#priceResult {
    transition: all 0.3s ease;
}
</style>

<script>
function updatePrice() {
    let base_total = {{ $total }};
    let addons = [];
    document.querySelectorAll('.addon-input').forEach(input => {
        let qty = parseInt(input.value) || 0;
        if(qty > 0) {
            addons.push({
                instrument_id: input.dataset.id,
                quantity: qty
            });
        }
    });

    fetch("{{ route('user.room.addons.calculate', $room->room_id) }}", {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}','Content-Type': 'application/json'},
        body: JSON.stringify({ base_total: base_total, addons: addons })
    })
    .then(res => res.json())
    .then(data => {
        const priceResult = document.getElementById('priceResult');

        // fade out
        priceResult.style.opacity = 0;

        setTimeout(() => {
            // อัปเดตข้อความใหม่
            priceResult.innerHTML = `
                <p><i class="bi bi-cash me-1"></i>Add-on Total: ${Number(data.addon_total).toFixed(2)} ฿</p>
                <p><i class="bi bi-check-circle me-1"></i>
                    <strong>Final Total: ${Number(data.final_total).toFixed(2)} ฿</strong>
                </p>
            `;

            // fade in
            priceResult.style.opacity = 1;
        }, 150); // รอให้ fade out เสร็จ (0.15s)
    });
}

function debounce(func, delay) {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), delay);
    };
}

document.querySelectorAll('.addon-input').forEach(input => {
    input.addEventListener('input', debounce(updatePrice, 300));
});

document.getElementById('confirmBtn').addEventListener('click', function(e) {
    e.preventDefault();

    let base_total = {{ $total }};
    let addon_total = 0;
    let addons = [];

    document.querySelectorAll('.addon-input').forEach(input => {
        let qty = parseInt(input.value) || 0;
        if(qty > 0) {
            addons.push({ id: input.dataset.id, quantity: qty, price: input.dataset.price });
            addon_total += qty * parseFloat(input.dataset.price);
        }
    });

    let final_total = base_total + addon_total;

    let params = new URLSearchParams({
        base_total: base_total,
        addon_total: addon_total,
        final_total: final_total,
        hours: "{{ $hours }}",
        start_time: "{{ $start_time }}",
        end_time: "{{ $end_time }}",
        addons: JSON.stringify(addons),
    });

    window.location.href = "{{ route('user.room.payment', $room->room_id) }}?" + params.toString();
});
</script>
@endsection
