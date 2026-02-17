<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGamer Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Kanit', sans-serif; background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 15px; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .btn-primary { border-radius: 10px; background: linear-gradient(45deg, #007bff, #00c6ff); border: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="index.php">PRO<span class="text-primary">GAMER</span></a>
        <div class="navbar-nav ms-auto align-items-center">
            <a class="nav-link px-3" href="index.php">หน้าแรก</a>
            <a class="nav-link position-relative px-3" href="cart.php">
                <i class="bi bi-cart3 fs-4"></i>
                <span class="badge rounded-pill bg-danger position-absolute top-0 start-50">
                    <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                </span>
            </a>
            <?php if(isset($_SESSION['username'])): ?>
                <a class="btn btn-outline-light ms-3" href="logout.php">ออกจากระบบ</a>
            <?php else: ?>
                <a class="btn btn-primary ms-3 px-4 shadow-sm" href="login.php">เข้าสู่ระบบ</a>
            <?php endif; ?>
        </div>
    </div>
</nav>