<?php
session_start();
include 'connectdb.php';
$error_message = '';
$success_message = '';

// แสดง Error ทั้งหมด (สำหรับ Debug)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['uname']);
    $email = trim($_POST['uemail']);
    $password = password_hash(trim($_POST['upassword']), PASSWORD_DEFAULT); // ใช้ password_hash แทน md5
    $address = trim($_POST['uaddress']);
    $phone = trim($_POST['uphone']);

    // เชื่อมต่อกับฐานข้อมูล
    $conn = new mysqli('localhost', 'root', '', 'yeastmaster');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตรวจสอบความซ้ำซ้อนของอีเมล
    $stmt = $conn->prepare("SELECT u_id FROM user WHERE u_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "อีเมลนี้ถูกใช้งานแล้ว กรุณาใช้ email อื่น";
    } else {
        // ตรวจสอบความซ้ำซ้อนของเบอร์มือถือ
        $stmt = $conn->prepare("SELECT u_id FROM user WHERE u_phone=?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "เบอร์มือถือหมายเลขนี้ถูกใช้งานแล้ว กรุณาใช้ เบอร์มือถืออื่น";
        } else {
            // เพิ่มข้อมูลลงในฐานข้อมูล
            $stmt = $conn->prepare("INSERT INTO user (u_name, u_email, u_password, u_address, u_phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $password, $address, $phone);

            if ($stmt->execute()) {
                $uid = $conn->insert_id; // ดึง id ของผู้ใช้ที่เพิ่งถูกเพิ่ม
                $_SESSION['uid'] = $uid; // เก็บ uid ใน session
                // เก็บข้อความสำเร็จไว้ใน session
                $_SESSION['success_message'] = "สมัครสมาชิกสำเร็จ!";
                // รีเฟรชหน้าโดย redirect ไปยัง URL ปัจจุบัน
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                $error_message = "เกิดข้อผิดพลาด: " . $conn->error;
            }
        }
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login Form | YeastMaster</title>
</head>
<body>
    <div id="particles-js"></div>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <!-- แสดงข้อความ Success และ Error -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="success-message"><?php echo $_SESSION['success_message']; ?></div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <h1>สมัครสมาชิก</h1>
                <div class="input-box">
                    <input type="text" name="uname" placeholder="Name" required>
                    <input type="email" name="uemail" placeholder="Email" required>
                    <input type="password" name="upassword" placeholder="Password" required>
                    <input type="text" name="uaddress" placeholder="Address" required>
                    <input type="text" name="uphone" placeholder="Phone" required>
                    <button type="submit">สมัครสมาชิก</button>
                </div>
            </form>
        </div>
        <div class="form-container sign-in">
            <form>
                <h1>เข้าสู่ระบบ</h1>
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Password"> 
                <a href="#">ลืมรหัสผ่านหรือไม่คะ?</a>
                <button>เข้าสู่ระบบ</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>ยินดีต้อนรับค่ะ</h1>
                    <p>กรอกรายละเอียดเพื่อให้เราเก็บข้อมูลสมาชิกของคุณ</p>
                    <button class="hidden" id="login">ไป เข้าสู่ระบบ</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>สวัสดีค่ะคุณลูกค้า</h1>
                    <p>กรุณาสมัครสมาชิกก่อนใช้งาน YeastMaster</p>
                    <button class="hidden" id="register">ไป สมัครสมาชิก</button>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
      particlesJS("particles-js", {
          particles: {
              number: { value: 150, density: { enable: true, value_area: 800 } },
              color: { value: "#ffffff" },
              shape: { type: "circle" },
              opacity: { value: 0.7, random: true },
              size: { value: 4, random: true },
              move: {
                  enable: true,
                  speed: 15,
                  direction: "bottom",
                  random: true,
                  straight: true,
                  out_mode: "out"
              },
              line_linked: { enable: false }
          },
          interactivity: {
              detect_on: "canvas",
              events: {
                  onhover: { enable: false },
                  onclick: {
                      enable: true,
                      mode: "push"
                  }
              },
              modes: {
                  push: { particles_nb: 20 }
              }
          }
      });
    </script>
    <!-- Code injected by live-server -->
    <script>
        if ('WebSocket' in window) {
            (function () {
                function refreshCSS() {
                    var sheets = [].slice.call(document.getElementsByTagName("link"));
                    var head = document.getElementsByTagName("head")[0];
                    for (var i = 0; i < sheets.length; ++i) {
                        var elem = sheets[i];
                        var parent = elem.parentElement || head;
                        parent.removeChild(elem);
                        var rel = elem.rel;
                        if (elem.href && (typeof rel !== "string" || rel.length === 0 || rel.toLowerCase() === "stylesheet")) {
                            var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
                            elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
                        }
                        parent.appendChild(elem);
                    }
                }
                var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
                var address = protocol + window.location.host + window.location.pathname + '/ws';
                var socket = new WebSocket(address);
                socket.onmessage = function (msg) {
                    if (msg.data === 'reload') window.location.reload();
                    else if (msg.data === 'refreshcss') refreshCSS();
                };
                if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
                    console.log('Live reload enabled.');
                    sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
                }
            })();
        } else {
            console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
        }
    </script>
</body>
</html>
