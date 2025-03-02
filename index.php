<?php
// เชื่อมต่อฐานข้อมูล
include 'connectdb.php';

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$query = "SELECT * FROM `product`";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeast Master Co., Ltd</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff; /* เปลี่ยนเป็นสีที่คุณต้องการ */
        }
        header {
            background-color: #ffffff;
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #ddd;
            position: relative;
        }

        header img {
            height: 50px;
        }

        header h1 {
            margin: 10px 0 5px;
            font-size: 24px;
            color: #004D40;
        }

        header p {
            font-size: 16px;
            color: #333;
        }

        .cart-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #004D40;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .menu-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: transparent;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

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
            border-bottom: 1px solid #004D40;
        }

        .menu a:hover {
            background-color: #004D40;
        }

        .menu.open {
            left: 0;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 250px;
            width: calc(100% - 250px);
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 5;
        }

        .overlay.show {
            display: block;
        }

        .slideshow {
            max-width: 100%;
            margin: 20px auto;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .slides {
            display: flex;
            transition: transform 1s ease-in-out;
        }

        .slide {
            min-width: 100%;
        }

        .slide img {
            width: 100%;
            display: block;
        }

        .products-section {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px;
            gap: 20px;
            background-color: #ffffff;
        }

        .product-card {
            background-color: #e6f7ff;
            width: 300px;
            height: 300px;
            text-align: center;
            border-radius: 10px;
            overflow: hidden;
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .about-section {
            background-color: #ffffff;
            padding: 20px;
            margin: 40px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        footer {
            background-color: #004D40;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
        .member-btn {
            position: absolute;
            top: 20px;
            right: 130px; /* ให้ปุ่มอยู่ข้างซ้ายของปุ่มตะกร้าสินค้า */
            background-color: #004D40;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .video-container {
            text-align: center;
            margin-top: 20px;
        }
        .video-container video {
            max-width: 800px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .about-section {
            background-color: #ffffff;
            padding: 20px;
            margin: 0 auto; /* จัดกรอบให้อยู่กึ่งกลาง */
            width: 100%; /* ให้กว้างเต็มจอ */
            text-align: center;
            border-radius: 0; /* ไม่ให้มุมโค้ง */
        }
    
        .image-container {
            display: flex;
            justify-content: center; /* จัดรูปภาพให้อยู่กึ่งกลาง */
            align-items: center;
            gap: 20px;
            width: 100%; /* ใช้พื้นที่เต็มจอ */
        }
    
        .image-container img {
            flex: 1; /* ให้รูปขยายพื้นที่ตามสัดส่วน */
            max-width: 100%; /* รูปจะไม่เกินพื้นที่กรอบ */
            height: auto; /* รักษาสัดส่วนของรูป */
            border-radius: 0; /* ไม่ให้รูปมีมุมโค้ง */
        }

    </style>
</head>
<body>
    <header>
        <button class="menu-btn" onclick="toggleMenu()">☰</button>
        <img src="images/1.png" alt="YMC Logo">
        <h1>YEAST MASTER CO., LTD</h1>
        <p>Manufacturing & Exporter <br> Feed Supplement for Aquatic & Live Stock</p>
        <a href="cart.php"class="member-btn">🛒 ตะกร้าสินค้า</a>
        <a href="login.php"class="cart-btn">🙍🏻‍♂️ สมาชิก</a>
    </header>

    <div class="slideshow">
        <div class="slides" id="slides">
            <div class="slide"><img src="images/slideshow1.png" alt="Slide 1"></div>
            <div class="slide"><img src="images/slideshow2.png" alt="Slide 2"></div>
            <div class="slide"><img src="images/slideshow3.png" alt="Slide 3"></div>
        </div>
    </div>

    <div class="overlay" id="overlay" onclick="closeMenu()"></div>

    <div class="menu" id="menu">
        <a href="index.php">สินค้าทั้งหมด</a>
        <a href="product-details-aquatic.php">อาหารเสริมสำหรับสัตว์น้ำ</a>
        <a href="product-details-plant.php">อาหารเสริมสำหรับพืช</a>
        <a href="product-details-livestock.php">อาหารเสริมสำหรับสัตว์บก</a>
        <a href="cart.php">ตะกร้าสินค้า</a>
    </div>

    <section class="products-section">
        <div class="product-card">
            <a href="product-details-aquatic.php">
                <img src="images/2.png" alt="Aquatic Feed">
            </a>
        </div>
        <div class="product-card">
            <a href="product-details-plant.php">
                <img src="images/4.png" alt="Plant Supplement">
            </a>
        </div>
        <div class="product-card">
            <a href="product-details-livestock.php">
                <img src="images/3.png" alt="Livestock Feed">
            </a>
        </div>
    </section>

    <section class="about-section">
        <h2>เกี่ยวกับเรา</h2>
        <p>
            Yeast Master Co., Ltd. เป็นผู้พัฒนาเทคโนโลยีการผลิตผลิตภัณฑ์ทางไบโอเทคโนโลยี (Bio Technology) <br>
            เพื่อใช้เป็นผลิตภัณฑ์อาหารเสริมสัตว์และพืชเศรษฐกิจ เพื่อเสริมสร้างสุขภาพสัตว์เลี้ยงและเพิ่มผลผลิต <br>
            อย่างมีประสิทธิภาพและปลอดภัยต่อผู้บริโภค
        </p>

        <div class="image-container">
            <img src="https://itp1.itopfile.com/ImageServer/itp_27072020394r/0/0/yeastmasterfarmaboutusz-z1499976804779.webp" 
                 alt="Image 1">
            <img src="https://itp1.itopfile.com/ImageServer/itp_27072020394r/0/0/yeastmasterfarmaboutus1z-z939207665742.webp" 
                 alt="Image 2">
        </div>

        <div class="media-container">
            <div class="image-container">
                <img src="images/gggg.png" alt="Image 1">
            </div>

        <div class="video-container">
            <div class="video-container">
                <iframe width="100%" height="400" src="https://www.youtube.com/embed/Fr_7d7K5vt4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </section>

    <footer>
        &copy; 2025 Yeast Master Co., | Ltd. All Rights Reserved.
    </footer>

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
    </script>
</body>
</html>
