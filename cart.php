<?php
session_start();
include 'connectdb.php';

// ลบสินค้าออกจากตะกร้า
if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// อัปเดตจำนวนสินค้าในตะกร้า
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] = intval($quantity);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า | Yeast Master</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .cart-img {
            width: 80px;
            border-radius: 5px;
        }
        .quantity {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .quantity input {
            width: 50px;
            text-align: center;
            font-size: 16px;
            margin: 0 10px;
        }
        .remove-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: red;
            font-size: 18px;
        }
        .summary {
            background: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .summary div {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }
        .checkout-btn {
            background: green;
            color: white;
            text-align: center;
            padding: 10px;
            display: block;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }
        header {
    position: relative;
    overflow: hidden;
    padding: 40px 20px;
    text-align: center;
    color: white;
    font-size: 36px;
    font-weight: bold;
    background-color: #004D40;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    height: auto; /* ให้ขนาดเท่าเดิม */
}

.background-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
}

.header-text {
    position: relative;
    z-index: 1;
    color: white;
    font-size: 36px;
    font-weight: bold;
}
        header h1 {
            margin: 10px 0 5px;
            font-size: 24px;
        }

        header p {
            font-size: 16px;
        }
        header {
    position: relative;
    z-index: 10; /* ทำให้ header อยู่ข้างบน */
}

header h1 {
    position: relative;
    z-index: 2; /* ให้อักษรอยู่ด้านบน */
}
        /* ปุ่มเมนูและตะกร้าสินค้า */
        .menu-btn,.member-btn {
            position: absolute;
            top: 20px;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .menu-btn {
            left: 20px;
            font-size: 24px;
        }

        .member-btn {
            right: 130px;
        }

        .cart-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* เมนู Sidebar */
        .menu {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #004D40;
            color: white;
            padding-top: 60px;
            transition: left 0.3s;
            z-index: 10;
        }

        .menu a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            font-size: 18px;
            border-bottom: 1px solid #00332e;
        }

        .menu.open {
            left: 0;
        }

        /* ส่วนแสดงสินค้า */
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            text-align: center;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-item {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .product-item img {
            width: 100%;
            height: 250px;
            object-fit: contain;
            border-radius: 10px;
            background-color: #fff;
            padding: 10px;
        }

        .menu-btn {
    position: absolute;
    top: 20px;
    left: 20px;
    color: white;
    background: none; /* ทำให้พื้นหลังโปร่งใส */
    border: none;     /* ลบกรอบปุ่ม */
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 24px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.menu-btn:focus {
    outline: none; /* ลบเส้นกรอบเมื่อคลิก */
}


        .product-item h3 {
            margin: 10px 0;
            color: #004D40;
            font-size: 18px;
            font-weight: bold;
        }

        .view-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: linear-gradient(to right, rgb(67, 185, 166), #004D40);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .view-btn:hover {
            background: linear-gradient(to right, #2F80ED, #56CCF2);
        }

        footer {
        position: relative;
        width: 100%;
        height: 80px; /* ปรับขนาดตามต้องการ */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    .footer-video {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }

    .footer-content {
        position: relative;
        z-index: 1;
    }

        .menu-btn {
    position: absolute;
    top: 20px;
    left: 20px;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 24px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

        .menu {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            color: white;
            padding-top: 60px;
            transition: left 0.3s;
            z-index: 10;
        }

        .menu a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .menu.open {
            left: 0;
        }
        /* เมนู Sidebar */
.menu {
    position: fixed;
    top: 0;
    left: -250px;
    width: 250px;
    height: 100%;
    color: white;
    padding-top: 60px;
    transition: left 0.3s;
    z-index: 20;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
    overflow-y: auto;
}

.menu.open {
    left: 0;
}

.menu a {
    display: block;
    padding: 15px;
    color: white;
    text-decoration: none;
    font-size: 18px;
}


.menu-icon {
    font-size: 30px;
    pointer-events: none; /* ทำให้คลิกได้ทั้งปุ่ม */
}

/* ปุ่ม Close */
.close-menu-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    color: white;
    font-size: 30px;
    cursor: pointer;
}

        .product-item p {
    height: 60px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3; 
    -webkit-box-orient: vertical;
    transition: height 0.3s;
}

.product-item p.expanded {
    height: auto;
    -webkit-line-clamp: unset;
}

.show-more-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-weight: bold;
    text-decoration: underline;
    margin-top: 5px;
}



/* กล่องครอบปุ่มให้เป็น inline-block และอยู่กึ่งกลาง */
.header-buttons {
    display: flex;
    justify-content: center;
    gap: 10px; /* ระยะห่างระหว่างปุ่ม */
    margin-top: 10px;
}

/* ปรับขนาดปุ่มให้เล็กลง */
.cart-btn{
    color: white;
    border: none;
    padding: 5px 10px; /* ปรับให้เล็กลง */
    font-size: 14px; /* ลดขนาดฟอนต์ */
    border-radius: 5px;
    cursor: pointer;
    display: inline-block;
}
.member-btn {
    color: white;
    border: none;
    padding: 5px 10px; /* ปรับให้เล็กลง */
    font-size: 14px; /* ลดขนาดฟอนต์ */
    border-radius: 5px;
    cursor: pointer;
    display: inline-block;
}
.member-btn {
    margin-left: 100px; /* ปรับระยะที่ต้องการ */
}
    
.cart-btn,
.member-btn {
    color: white;
    background: none;  /* ทำให้พื้นหลังโปร่งใส */
    border: none;      /* ลบกรอบปุ่ม */
    padding: 5px 10px; /* ปรับขนาดให้เล็กลง */
    font-size: 16px;   /* ลดขนาดฟอนต์ */
    border-radius: 5px;
    cursor: pointer;
    transition: color 0.3s;
}

.cart-btn:hover,
.member-btn:hover {
    color:rgb(0, 103, 221); /* เปลี่ยนสีเมื่อชี้เมาส์ */
}

.cart-btn:focus,
.member-btn:focus {
    outline: none; /* ลบเส้นกรอบเมื่อคลิก */
}
    </style>

<script>
    function toggleDetails(button) {
        const detail = button.previousElementSibling;
        detail.classList.toggle("expanded");

        if (detail.classList.contains("expanded")) {
            button.textContent = "แสดงน้อยลง";
        } else {
            button.textContent = "แสดงเพิ่มเติม";
        }
        }

        function toggleMenu() {
            const menu = document.getElementById("menu");
            const overlay = document.getElementById("overlay");

            menu.classList.toggle("open");
            overlay.classList.toggle("show");
        }

        function closeMenu() {
            document.getElementById("menu").classList.remove("open");
            document.getElementById("overlay").classList.remove("show");
        }

        let currentIndex = 0;
        const slides = document.getElementById("slides");
        const totalSlides = document.querySelectorAll(".slide").length;

        function showNextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            slides.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        setInterval(showNextSlide, 3000);

        function toggleMenu() {
        const menu = document.getElementById("menu");
        menu.classList.toggle("open");
    }

    function closeMenu() {
        const menu = document.getElementById("menu");
        menu.classList.remove("open");
    }

    // ปิดเมนูเมื่อคลิกภายนอก
    window.addEventListener("click", function(event) {
        const menu = document.getElementById("menu");
        const menuBtn = document.querySelector(".menu-btn");

        if (!menu.contains(event.target) && !menuBtn.contains(event.target)) {
            menu.classList.remove("open");
        }
        function addToCart(productId, productName, productPrice, productImage) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('product_name', productName);
        formData.append('product_price', productPrice);
        formData.append('product_image', productImage);

        fetch('add_to_cart.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
          .then(data => {
              if (data === "success") {
                  alert('เพิ่มสินค้าในตะกร้าแล้ว!');
              }
          });
    }
    });
    </script>

<div class="menu" id="menu">
    <button class="close-menu-btn" onclick="closeMenu()">×</button>
        <a href="index.php">สินค้าทั้งหมด</a>
        <a href="product-details-aquatic.php">อาหารเสริมสำหรับสัตว์น้ำ</a>
        <a href="product-details-plant.php">อาหารเสริมสำหรับพืช</a>
        <a href="product-details-livestock.php">อาหารเสริมสำหรับสัตว์บก</a>
        <a href="cart.php">ตะกร้าสินค้า</a>
    </div>

</head>
<body>
<header>
    <button class="menu-btn" onclick="toggleMenu()">
        <span class="menu-icon">☰</span>
    </button>

    <video autoplay muted loop class="background-video">
    <source src="videos/w.mp4" type="video/mp4">
    </video>

    <div class="header-buttons">
        <a href="login.php" class="member-btn">🙍🏻‍♂️ สมาชิก</a>
    </div>
</header>
    <div class="container">
    <h1>ตะกร้าสินค้า</h1>
    <?php if (!empty($_SESSION['cart'])) { ?>
        <form action="cart.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>รูปสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th>รวม</th>
                        <th>การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $product_id => $item) {
                        if (isset($item['price']) && isset($item['quantity'])) {
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                    ?>
                            <tr>
                                <td><img src="images/<?php echo $item['image']; ?>" width="100"></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo number_format($item['price'], 2); ?> บาท</td>
                                <td>
                                    <input type="number" name="quantity[<?php echo $product_id; ?>]" 
                                           value="<?php echo $item['quantity']; ?>" min="1">
                                </td>
                                <td><?php echo number_format($subtotal, 2); ?> บาท</td>
                                <td><a href="cart.php?remove=<?php echo $product_id; ?>">ลบ</a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="4"><strong>รวมทั้งหมด</strong></td>
                        <td><strong><?php echo number_format($total, 2); ?> บาท</strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit">อัปเดตตะกร้า</button>
        </form>
        <a href="checkout.php" onclick="return confirm('คุณต้องการชำระเงินและกลับสู่หน้าหลักหรือไม่?');">ชำระเงิน</a>
    <?php } else { ?>
        <p>ไม่มีสินค้าในตะกร้า</p>
    <?php } ?>



</body>
</html>