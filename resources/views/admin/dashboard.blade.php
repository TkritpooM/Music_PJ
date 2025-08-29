<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Music Studio Admin</a>
        <div class="ms-auto">
            <a href="{{ route('logout') }}" class="btn btn-outline-light"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout
            </a>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<div class="container mt-5">
    <h1 class="mb-4">Welcome, Admin!</h1>
    <p>นี่คือหน้า Dashboard ของผู้ดูแลระบบ</p>

    <!-- ตัวอย่าง Card -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">จัดการผู้ใช้งานทั้งหมด</p>
                    <a href="#" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rooms</h5>
                    <p class="card-text">ดู/แก้ไขห้องซ้อม</p>
                    <a href="#" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bookings</h5>
                    <p class="card-text">ตรวจสอบการจองทั้งหมด</p>
                    <a href="#" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
