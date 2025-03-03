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
            font-size: 2rem;
            color: #333;
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
        /* การตกแต่งปุ่ม */
        button, a {
            background-color: #004D40;
            color: white;
            font-size: 1.1rem;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
        }

        button:hover, a:hover {
            background-color: #00897B;
            transform: translateY(-2px);
        }

        button:focus, a:focus {
            outline: none;
        }

        /* ปุ่ม "ชำระเงิน" */
        .checkout-btn {
            background: green;
            color: white;
            text-align: center;
            padding: 12px 25px;
            display: block;
            border-radius: 50px;
            text-decoration: none;
            margin-top: 10px;
            font-size: 1.1rem;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .checkout-btn:hover {
            background-color: #00796b;
            transform: translateY(-2px);
        }

        .checkout-btn:focus {
            outline: none;
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

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน | Yeast Master</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <button class="menu-btn" onclick="toggleMenu()">
        <span class="menu-icon">☰</span>
    </button>

    <video autoplay muted loop class="background-video">
    <source src="videos/555.mp4" type="video/mp4">
    </video>

    <div class="menu" id="menu">
    <button class="close-menu-btn" onclick="closeMenu()">×</button>
        <a href="index.php">สินค้าทั้งหมด</a>
        <a href="product-details-aquatic.php">อาหารเสริมสำหรับสัตว์น้ำ</a>
        <a href="product-details-plant.php">อาหารเสริมสำหรับพืช</a>
        <a href="product-details-livestock.php">อาหารเสริมสำหรับสัตว์บก</a>
        <a href="cart.php">ตะกร้าสินค้า</a>
        <a href="checkout.php">ชำระเงิน</a>
    </div>
</header>
</head>
<body class="bg-blue-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-6">
            <h2 class="text-2xl font-bold mb-4 text-center">ชำระเงิน</h2>

            <div class="flex justify-between mb-4">
                <div class="text-center">
                    <span class="text-blue-500 font-bold">&#10003;</span>
                    <p class="text-sm">ตะกร้าสินค้า</p>
                </div>
                <div class="text-center">
                    <span class="text-blue-500 font-bold">&#10003;</span>
                    <p class="text-sm">ที่อยู่จัดส่ง</p>
                </div>
                <div class="text-center">
                    <span class="text-blue-500 font-bold">&#10003;</span>
                    <p class="text-sm">วิธีชำระเงิน</p>
                </div>
                <div class="text-center">
                    <span class="text-gray-400">&#10095;</span>
                    <p class="text-sm">ตัวอย่างสินค้า</p>
                </div>
            </div>

            <form action="checkout.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="card-number">หมายเลขบัตร</label>
                    <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2" for="expiration-date">วันหมดอายุบัตร Date</label>
                        <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/YY" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2" for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="123" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="card-holder">ชื่อ-นามสกุล</label>
                    <input type="text" id="card-holder" name="card-holder" placeholder="ชื่อบัญชี" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">ยืนยันการชำระเงิน</button>
            </form>
        </div>
    </div>
<script>
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
</body>
</html>