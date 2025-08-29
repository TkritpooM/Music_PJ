<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Music Studio</a>
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
    <h1 class="mb-4">Welcome, {{ Auth::user()->firstname }}!</h1>
    <p>นี่คือหน้า Home ของผู้ใช้งาน</p>

    <!-- ตัวอย่าง Card -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Book a Room</h5>
                    <p class="card-text">จองห้องซ้อมของคุณได้ที่นี่</p>
                    <a href="#" class="btn btn-primary">Book Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">My Bookings</h5>
                    <p class="card-text">ดูรายการจองของคุณ</p>
                    <a href="#" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
