<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
$userDB           = "root";
$passDB           = "";
$server           = "";
$DBase            = "";

$conn['host']     = $server;
$conn['dbname']   = $DBase;
$conn['username'] = $userDB;
$conn['password'] = $passDB;

// Kết nối MySQLi
$connect = new mysqli($server, $userDB, $passDB, $DBase);
$connect->set_charset("UTF8");

// Kiểm tra kết nối
if ($connect->connect_error) {
    die("Bảo trì quay lại sau " . $connect->connect_error);
    exit();
}

$status = $connect->real_escape_string($_GET['status']);
$message = $connect->real_escape_string($_GET['message']);
$amount = $connect->real_escape_string($_GET['amount']);
$value = $connect->real_escape_string($_GET['value']);
$request_id = $connect->real_escape_string($_GET['request_id']);

if ($status == 1 || $status == 2) {
    // Nếu trạng thái là 1 hoặc 2 (thành công)
    $result = $connect->query("SELECT request_id, user_id FROM topup WHERE request_id='$request_id'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Lấy thông tin user
        $user_query = $connect->query("SELECT * FROM `user` WHERE `id`='$user_id' LIMIT 1");
        $u = $user_query->fetch_assoc();

        // Kiểm tra nếu topup trạng thái là 0
        $topup_query = $connect->query("SELECT * FROM `topup` WHERE `request_id`='$request_id' LIMIT 1");
        $id = $topup_query->fetch_assoc();

        if ($id['trangthai'] == 0) {
            $chia = $value;

            // Update trạng thái topup và cập nhật số dư
            $connect->query("UPDATE `topup` SET `trangthai` = '1' WHERE `request_id` = '$request_id' ");
            $connect->query("UPDATE `user` SET `vnd` = `vnd` + '" . ($value + $chia) . "', `tongnap` = `tongnap` + '$value' WHERE `id` = '$user_id' ");
            $connect->query("UPDATE `user` SET `diemnap` = `diemnap` + '$value' WHERE `id` = '$user_id' ");

            // Tạo giftcode nếu nạp từ 20,000 VNĐ trở lên
            if ($value >= 20000) {
                $numLoops = floor($value / 20000);

                for ($i = 0; $i < $numLoops; $i++) {
                    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                    $length = 5; // Độ dài của chuỗi
                    $randomString = substr(str_shuffle($characters), 0, $length);

                    $connect->query("INSERT INTO giftcode(`code`, `count`, `time_expire`, `type`, `username`) VALUES ('$randomString', '1', '2030-06-30 00:00:00', '2', '" . $u['username'] . "');");
                }
            }

            echo ' ' . $user_id . ' + ' . $value . 'vnd <br>';
        }
    }
} else if ($status == 3) {
    // Nếu trạng thái là 3 (thẻ lỗi)
    $connect->query("UPDATE `topup` SET `trangthai` = '3' WHERE `request_id` = '$request_id' ");
} else if ($status == 99) {
    // Nếu trạng thái là 99 (Gửi thẻ thành công, đợi duyệt)
    $connect->query("UPDATE `topup` SET `trangthai` = '99' WHERE `request_id` = '$request_id' ");
} else {
    // Trường hợp khác (có lỗi)
    $connect->query("UPDATE `topup` SET `trangthai` = '999' WHERE `request_id` = '$request_id' ");
}

?>
