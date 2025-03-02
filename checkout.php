<?php
session_start();
include 'connectdb.php';

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// บันทึกคำสั่งซื้อลงฐานข้อมูล (ตัวอย่าง)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = 0;
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // บันทึกคำสั่งซื้อ (ตัวอย่าง)
    $query = "INSERT INTO orders (total_amount) VALUES ($total)";
    mysqli_query($conn, $query);

    // ล้างตะกร้าสินค้า
    unset($_SESSION['cart']);

    // เปลี่ยนเส้นทางกลับไปที่หน้าหลัก
    header("Location: index.php");

    echo "<p>ชำระเงินสำเร็จ!</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน | Yeast Master</title>
</head>
<body>
    <h1>ชำระเงิน</h1>
    <form action="checkout.php" method="POST">
        <button type="submit">ยืนยันการชำระเงิน</button>
    </form>
</body>
</html>