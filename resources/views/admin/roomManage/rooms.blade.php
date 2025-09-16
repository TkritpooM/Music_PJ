@extends('layout.adminlayout')

@section('title', 'Rooms Management')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary">จัดการห้องซ้อม</h2>

    {{-- ข้อความสำเร็จ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- แสดง Error --}}
    @if ($errors->any() && ! $errors->hasBag('instrumentRoom'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle me-1"></i> {{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ฟอร์มเพิ่มห้อง --}}
    <div class="card glass-card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-md-2">
                        <input type="text" name="name" class="form-control" placeholder="ชื่อห้อง" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="price_per_hour" class="form-control" placeholder="ราคา/ชม." required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="capacity" class="form-control" placeholder="จำนวนคน" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="description" class="form-control" placeholder="คำอธิบาย">
                    </div>
                    <div class="col-md-2">
                        <input type="file" name="image_url" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> เพิ่ม
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ตารางห้อง --}}
    <div class="card glass-card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ชื่อห้อง</th>
                            <th>ราคา/ชม.</th>
                            <th>จำนวนคน</th>
                            <th>รายละเอียด</th>
                            <th>รูป</th>
                            <th>เครื่องดนตรี</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                        <tr>
                            <td class="fw-semibold">{{ $room->name }}</td>
                            <td>{{ number_format($room->price_per_hour, 2) }}</td>
                            <td>{{ $room->capacity }}</td>
                            <td class="text-truncate" style="max-width: 150px;">{{ $room->description }}</td>
                            <td>
                                @if($room->image_url)
                                    <img src="{{ asset('storage/' . $room->image_url) }}" width="80" class="img-thumbnail rounded">
                                @else
                                    <span class="text-muted small">ไม่มีรูป</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.rooms.instruments', $room->room_id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-music-note-list me-1"></i> {{ $room->instruments->count() }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-2">
                                    <a href="{{ route('admin.rooms.edit', $room->room_id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil-square me-1"></i> แก้ไข
                                    </a>
                                    <form class="delete-room-form m-0" action="{{ route('admin.rooms.delete', $room->room_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash me-1"></i> ลบ
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 d-flex justify-content-center">
                    <nav>
                        {{ $rooms->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 16px;
        transition: all 0.2s ease-in-out;
    }
    .glass-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .table-hover tbody tr:hover {
        background: rgba(255, 255, 255, 0.4);
    }
    .pagination {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 12px;
        padding: 0.25rem 0.5rem;
    }

    .pagination .page-link {
        color: #0d6efd;
        background-color: rgba(255, 255, 255, 0.4);
        border: none;
        margin: 0 2px;
        transition: all 0.2s;
    }

    .pagination .page-link:hover {
        background-color: rgba(255, 255, 255, 0.7);
        color: #0a58ca;
    }

    .pagination .page-item.active .page-link {
        background-color: rgba(13, 110, 253, 0.8);
        color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
</style>
@endpush

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // SweetAlert สำหรับลบห้อง
    document.querySelectorAll('.delete-room-form').forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'ยืนยันการลบ',
                text: 'คุณแน่ใจว่าจะลบห้องนี้?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });

    // SweetAlert success หลังเพิ่มห้อง
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif

});
</script>
@endpush

@endsection
