@extends('layout.userlayout')

@section('title', 'Payment')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Payment</h2>

    <!-- Glassmorphism Card -->
    <div class="glass-card p-4 shadow-sm">
        <div class="row g-4 align-items-center">
            <!-- Room Image -->
            <div class="col-md-5 text-center">
                <img src="{{ $room->image_url ? asset('storage/'.$room->image_url) : 'https://shorturl.at/YT5O1' }}" 
                     class="room-img img-fluid rounded shadow-sm" alt="{{ $room->name }}">
            </div>

            <!-- Room Details -->
            <div class="col-md-7">
                <h4 class="fw-bold">{{ $room->name }}</h4>
                <p class="text-muted mb-3">
                    <i class="bi bi-clock me-1"></i>
                    Duration: <strong>{{ $hours }} ชั่วโมง</strong>
                    ({{ \Carbon\Carbon::parse($start_time)->format('d/m/Y H:i') }} - 
                     {{ \Carbon\Carbon::parse($end_time)->format('d/m/Y H:i') }})
                </p>

                <!-- Price List -->
                <ul class="list-group mb-3 price-list">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Room Price</span>
                        <strong>{{ number_format($base_total,2) }} ฿</strong>
                    </li>

                    <li class="list-group-item d-flex flex-column align-items-start">
                        <div class="d-flex justify-content-between w-100">
                            <span>Add-ons</span>
                            <strong>{{ number_format($addon_total,2) }} ฿</strong>
                        </div>
                        @if(!empty($addons))
                        <div class="mt-2 w-100 p-3 rounded-3 addon-list">
                            <ul class="list-group list-group-flush">
                                @foreach($addons as $addon)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" 
                                        style="background: transparent; border: none; padding: 0.35rem 0;">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-music-note"></i>
                                            <span>
                                                Instrument ID: {{ $addon['id'] ?? ($addon['instrument_id'] ?? 'N/A') }}
                                                (Qty: {{ $addon['quantity'] ?? ($addon['qty'] ?? 0) }})
                                            </span>
                                        </div>
                                        @if(isset($addon['price']))
                                            <strong class="text-end">
                                                {{ number_format($addon['price'] * ($addon['quantity'] ?? ($addon['qty'] ?? 0)), 2) }} ฿
                                            </strong>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Total</span>
                        <strong>{{ number_format($final_total,2) }} ฿</strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                        <span>Deposit (50%)</span>
                        <strong>{{ number_format($deposit,2) }} ฿</strong>
                    </li>
                </ul>

                <!-- Payment Form -->
                <form id="paymentForm" action="{{ route('user.room.qrcode', $room->room_id) }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="hours" value="{{ $hours }}">
                    <input type="hidden" name="start_time" value="{{ $start_time }}">
                    <input type="hidden" name="end_time" value="{{ $end_time }}">
                    <input type="hidden" name="final_total" value="{{ $final_total }}">
                    <input type="hidden" name="addons" value='@json($addons)'>

                    <div class="d-flex gap-3">
                        <!-- Cancel -->
                        <a href="{{ route('user.home') }}" 
                           class="btn btn-outline-secondary flex-fill rounded-3 btn-cancel">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>

                        <!-- Pay -->
                        <button type="button" 
                                class="btn btn-primary flex-fill rounded-3 btn-pay"
                                data-bs-toggle="modal" data-bs-target="#termsModal">
                            <i class="bi bi-credit-card me-2"></i> Pay → QR Code
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content glass-card p-3">
      
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="termsModalLabel">Terms & Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <ul class="mb-3">
            <li>Payment is 50% deposit of total amount.</li>
            <li>Once payment is made, booking cannot be canceled.</li>
            <li>Please arrive on time for your booking.</li>
            <li>Any damages or missing instruments are the responsibility of the user.</li>
            <li>Check your booking details carefully before proceeding.</li>
        </ul>
        <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" id="acceptTerms">
            <label class="form-check-label fw-semibold" for="acceptTerms">
                I accept the terms & conditions
            </label>
        </div>
      </div>
      
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">
            Cancel
        </button>
        <button type="button" class="btn btn-primary rounded-3 px-4" id="confirmPayBtn" disabled>
            Confirm
        </button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
body {
    background: #f0f2f5;
    min-height: 100vh;
    font-family: "Inter", sans-serif;
}

/* Glass Card */
.glass-card {
    background: rgba(255, 255, 255, 0.75);
    border-radius: 16px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(200, 200, 200, 0.3);
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

/* Room Image */
.room-img {
    width: 100%;
    max-width: 300px;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
}

/* Price list minimal */
.price-list .list-group-item {
    background: rgba(255,255,255,0.4);
    border: none;
    border-radius: 12px;
    margin-bottom: 8px;
    padding: 0.75rem 1rem;
}

/* Addon list */
.addon-list {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(8px);
}

/* Buttons */
.btn-cancel {
    border: 1px solid rgba(0,0,0,0.1);
    background: rgba(255,255,255,0.5);
    color: #333;
    font-weight: 500;
    transition: all 0.2s;
}
.btn-cancel:hover {
    background: rgba(255,255,255,0.75);
}

.btn-pay {
    background: linear-gradient(135deg,#28a745,#5cd65c);
    border: none;
    font-weight: 500;
    transition: all 0.2s;
}
.btn-pay:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40,167,69,0.3);
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('paymentForm');
    const termsModal = document.getElementById('termsModal');

    termsModal.addEventListener('shown.bs.modal', function () {
        const checkbox = termsModal.querySelector('#acceptTerms');
        const confirmBtn = termsModal.querySelector('#confirmPayBtn');

        confirmBtn.disabled = true;

        checkbox.onchange = function() {
            confirmBtn.disabled = !this.checked;
        };

        confirmBtn.onclick = function() {
            paymentForm.submit();
        };
    });
});
</script>
@endsection
