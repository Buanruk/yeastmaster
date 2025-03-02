<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost"; // ชื่อเซิร์ฟเวอร์
$username = "root"; // ชื่อผู้ใช้ (ค่าเริ่มต้นของ XAMPP คือ root)
$password = ""; // รหัสผ่าน (ค่าเริ่มต้นว่างเปล่า)
$dbname = "yeastmaster"; // ชื่อฐานข้อมูลที่สร้างไว้

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
