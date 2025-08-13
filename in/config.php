<?php
session_start();

date_default_timezone_set('Asia/Ho_Chi_Minh');
header("Content-type: text/html; charset=utf-8");

$userDB = "root";
$passDB = "88888888";
$server = "localhost";
$DBase  = "langla";

// Kết nối với cơ sở dữ liệu bằng mysqli
$connect = new mysqli($server, $userDB, $passDB, $DBase);
$connect->set_charset("UTF8");

if ($connect->connect_error) {
    die("Bảo trì quay lại sau " . $connect->connect_error);
}

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user'])) {
    $stmt = $connect->prepare("SELECT * FROM `player` WHERE `username` = ? LIMIT 1");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}
?>
