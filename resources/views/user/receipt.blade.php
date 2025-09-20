@extends('layout.userlayout')

@section('title', 'Receipt')

@section('content')
<div class="container py-5">
    <div class="card p-4 shadow-sm receipt-card">
        <h3 class="mb-4">Receipt</h3>

        <div class="mb-3">
            <p><strong>Receipt Number:</strong> {{ $receipt->receipt_number }}</p>
            <p><strong>Booking Number:</strong> {{ $booking->booking_id }}</p>
            <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($receipt->created_at)->format('d M Y H:i') }}</p>
        </div>

        <hr class="my-4">

        <h5>Room Info</h5>
        <p><i class="bi bi-house-door-fill me-2"></i>{{ $booking->room->name }}</p>
        <p><i class="bi bi-clock-fill me-2"></i> {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i') }}</p>

        @if($addons->count())
        <h5 class="mt-4">Add-ons</h5>
        <ul class="list-group addon-list mb-3">
            @foreach($addons as $addon)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $addon->instrument->name }} x{{ $addon->quantity }}</span>
                    <strong>{{ number_format($addon->price * $addon->quantity, 2) }} ฿</strong>
                </li>
            @endforeach
        </ul>
        @endif

        <h5>Payment Details</h5>
        <ul class="list-group payment-list mb-3">
            <li class="list-group-item d-flex justify-content-between">
                <span>Total Amount</span>
                <strong>{{ number_format($receipt->full_amount, 2) }} ฿</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Deposit Paid</span>
                <strong>{{ number_format($receipt->deposit_amount, 2) }} ฿</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Discount</span>
                <strong>{{ number_format($receipt->discount_amount, 2) }} ฿</strong>
            </li>
        </ul>

        <div class="d-flex gap-3 mt-3">
            <a href="{{ route('user.bookings') }}" class="btn btn-outline-secondary flex-fill btn-back">
                <i class="bi bi-arrow-left-circle me-2"></i> Back to Bookings
            </a>
            <a href="{{ route('user.room.receipt.pdf', $booking->booking_id) }}" class="btn btn-primary flex-fill btn-download">
                <i class="bi bi-file-earmark-pdf me-2"></i> Download PDF
            </a>
        </div>
    </div>
</div>

<style>
body {
    background: #f5f5f8;
    font-family: 'Inter', sans-serif;
}

.receipt-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    border-radius: 15px;
    border: 1px solid rgba(200, 200, 200, 0.25);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.addon-list .list-group-item,
.payment-list .list-group-item {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    border-radius: 8px;
    margin-bottom: 6px;
    padding: 0.65rem 1rem;
}

.addon-list .list-group-item strong,
.payment-list .list-group-item strong {
    font-weight: 600;
}

.btn-back, .btn-download {
    border-radius: 10px;
    font-weight: 500;
    padding: 0.55rem 1rem;
    transition: all 0.2s;
}

.btn-back {
    background: rgba(255, 255, 255, 0.25);
    border: 1px solid rgba(0,0,0,0.15);
    color: #333;
    transition: all 0.2s;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.45);
    color: #111;
}

.btn-download {
    background: linear-gradient(135deg, #28a745, #5cd65c);
    border: none;
    color: #fff;
}

.btn-download:hover {
    filter: brightness(1.1);
}

h3, h5 {
    color: #111;
}
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
@endsection
