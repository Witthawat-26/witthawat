<?php 
include('includes/db_connect.php'); 
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
include('includes/header.php'); 

$id = $_GET['id']; // รับ ID สินค้าจาก URL
$res = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
$p = mysqli_fetch_assoc($res);
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div id="carouselExample" class="carousel slide shadow" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    $img_res = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $id");
                    $active = "active";
                    while($img = mysqli_fetch_assoc($img_res)) { ?>
                        <div class="carousel-item <?php echo $active; ?>">
                            <img src="assets/uploads/<?php echo $img['image_path']; ?>" class="d-block w-100">
                        </div>
                    <?php $active = ""; } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h1><?php echo $p['product_name']; ?></h1>
            <h2 class="text-danger"><?php echo number_format($p['price']); ?> ฿</h2>
            <p class="mt-4"><?php echo $p['description']; ?></p>
            <a href="cart.php?add=<?php echo $p['product_id']; ?>" class="btn btn-success btn-lg">หยิบลงตะกร้า</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>