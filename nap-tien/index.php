<?php
$title = 'Lịch sử nạp thẻ';
include '../in/head.php';

if (!isset($_SESSION['user'])) {
    echo '<center>Bạn vui lòng đăng nhập</center>';
} else {
    echo '<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
            <div class="page-layout-body">
                <div class="card">
                    <div class="card-header">Nạp tiền bằng thẻ cào</div>
                    <div class="card-body">';

    if (isset($_POST['napthe'])) {
        $lock = false;
        $time = time();

        if (!($_POST['telco']) || !($_POST['amount']) || !($_POST['serial']) || !($_POST['code'])) {
            echo '<span style="color: red; font-size: 12px; font-weight: bold;">Chưa nhập đủ thông tin</span>';
        } else if ($lock) {
            echo '<span style="color: red; font-size: 12px; font-weight: bold;">Nạp thẻ đang đóng vui lòng thử lại sau</span>';
        } else if ($user['timenap'] > $time) {
            echo '<span style="color: red; font-size: 12px; font-weight: bold;">Vui lòng đợi ' . ($user['timenap'] - $time) . ' giây nữa và nạp lại nhé bạn</span>';
        } else if (mysqli_num_rows(mysqli_query($connect, "SELECT `id` FROM `topup` WHERE `user_id`='" . $user['id'] . "' AND trangthai != '1' AND trangthai != '2'")) >= 3) {
            echo '<span style="color: red; font-size: 12px; font-weight: bold;">Bạn đã bị khóa nạp 2 tiếng do nạp sai thẻ quá nhiều lần</span>';
            mysqli_query($connect, "UPDATE `player` SET `timenap` = '" . ($time + 7200) . "' WHERE `id` = '" . $user['id'] . "'");
            mysqli_query($connect, "DELETE FROM `topup` WHERE `user_id` = '" . $user['id'] . "' AND `trangthai` != '1'");
        } else {
            mysqli_query($connect, "UPDATE `player` SET `timenap` = '" . ($time + 30) . "' WHERE `id` = '" . $user['id'] . "'");

            $request_id = rand(100000000, 999999999);  // Mã đơn hàng của bạn
            $command = 'charging';  // Nap the
            $url = 'https://thesieure.com/chargingws/v2?';
            $partner_id = '42246147282';
            $partner_key = '1d3794417915ac304982f6279deda78c';

            $dataPost = array(
                'request_id' => $request_id,
                'code' => $_POST['code'],
                'partner_id' => $partner_id,
                'serial' => $_POST['serial'],
                'telco' => $_POST['telco'],
                'command' => $command
            );

            ksort($dataPost);
            $sign = $partner_key;
            foreach ($dataPost as $item) {
                $sign .= $item;
            }

            $mysign = md5($sign);
            $dataPost['amount'] = $_POST['amount'];
            $dataPost['sign'] = $mysign;

            $data = http_build_query($dataPost);
            $url .= $data;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($ch);
            curl_close($ch);

            $obj = json_decode($result);

            if ($obj->status == 99) {
                // Gửi thẻ thành công, đợi duyệt.
                $time = date("H:i:s d-m-Y");
                mysqli_query($connect, "INSERT INTO topup(`request_id`,`trangthai`, `vnd`, `user_id`, `time`,`ma`,`seri`) VALUES ('" . $request_id . "','0','" . $_POST['amount'] . "','" . $user['id'] . "','" . $time . "','" . $_POST['code'] . "','" . $_POST['serial'] . "');");
                echo '<span style="color: green; font-size: 12px; font-weight: bold;">Nạp thành công. Vui lòng đợi duyệt tự động thời gian từ 1-5 phút!</span>';
            } elseif ($obj->status == 1) {
                // Thành công
                mysqli_query($connect, "INSERT INTO topup(`request_id`,`trangthai`, `vnd`, `user_id`, `time`,`ma`,`seri`) VALUES ('" . $request_id . "','1','" . $obj->amount . "','" . $user['id'] . "','" . $time . "','" . $_POST['code'] . "','" . $_POST['serial'] . "');");

                $value = $obj->value;
                $chia = $value * 1.5;

                mysqli_query($connect, "UPDATE `player` SET `vnd` = `vnd` + '" . ($value + $chia) . "', `tongnap` = `tongnap` + '" . $value . "' WHERE `id` = '" . $user['id'] . "'");
                mysqli_query($connect, "UPDATE `player` SET `vnd-back` = `vnd-back` + '" . ($value + $chia) . "' WHERE `id` = '" . $user['id'] . "'");

                echo '<span style="color: green; font-size: 12px; font-weight: bold;">Nạp thành công! Bạn nhận được ' . $obj->value . ' VNĐ</span>';
            } elseif ($obj->status == 2) {
                // Thành công nhưng sai mệnh giá
                mysqli_query($connect, "INSERT INTO topup(`request_id`,`trangthai`, `vnd`, `user_id`, `time`,`ma`,`seri`) VALUES ('" . $request_id . "','1','" . $obj->amount . "','" . $user['id'] . "','" . $time . "','" . $_POST['code'] . "','" . $_POST['serial'] . "');");

                $value = $obj->value;
                $chia = $value * 1.5;

                mysqli_query($connect, "UPDATE `player` SET `vnd` = `vnd` + '" . ($value + $chia) . "', `tongnap` = `tongnap` + '" . $value . "' WHERE `id` = '" . $user['id'] . "'");
                mysqli_query($connect, "UPDATE `player` SET `vnd-back` = `vnd-back` + '" . ($value + $chia) . "' WHERE `id` = '" . $user['id'] . "'");

                echo '<span style="color: green; font-size: 12px; font-weight: bold;">Nạp thành công! Bạn nhận được ' . $obj->value . ' VNĐ</span>';
            } elseif ($obj->status == 3) {
                // Thẻ lỗi
                echo '<span style="color: red; font-size: 12px; font-weight: bold;">Mã thẻ, seri không đúng</span>';
            } elseif ($obj->status == 4) {
                // Bảo trì
                echo '<span style="color: red; font-size: 12px; font-weight: bold;">Lỗi hệ thống, thử lại sau</span>';
            } else {
                if (!$obj->message) {
                    echo '<span style="color: red; font-size: 12px; font-weight: bold;">Lỗi hệ thống, thử lại sau</span>';
                } else {
                    echo '<span style="color: red; font-size: 12px; font-weight: bold;">' . $obj->message . '!</span>';
                }
            }
        }
    }

    echo '
    <form action="" accept-charset="UTF-8" method="post">
        <div class="form-group">
            <label for="pwd">Loại thẻ:</label>
            <select class="form-control" name="telco" required="">
                <option value="">- Chọn nhà mạng -</option>
                <option value="VIETTEL">Viettel</option>
                <option value="VINAPHONE">Vinaphone</option>
                <option value="MOBIFONE">Mobifone</option>
            </select>
        </div>
        <div class="form-group">
            <label for="pwd">Mã thẻ cào:</label>
            <input class="form-control" type="text" name="code" placeholder="Mã thẻ ..." required="">
        </div>
        <div class="form-group">
            <label for="pwd">Serial trên thẻ:</label>
            <input class="form-control" type="text" name="serial" placeholder="Serial ..." required="">
        </div>
        <div class="form-group">
            <label for="pwd">Mệnh giá:</label>
            <select class="form-control" name="amount" required="">
                <option value="">- Chọn mệnh giá -</option>
                <option value="10000">10,000 VNĐ</option>
                <option value="20000">20,000 VNĐ</option>
                <option value="30000">30,000 VNĐ</option>
                <option value="50000">50,000 VNĐ</option>
                <option value="100000">100,000 VNĐ</option>
                <option value="200000">200,000 VNĐ</option>
                <option value="300000">300,000 VNĐ</option>
                <option value="500000">500,000 VNĐ</option>
                <option value="1000000">1,000,000 VNĐ</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="napthe" class="btn btn-danger">Yêu cầu nạp thẻ</button>
        </div>
    </form>
</div>
</div>
</div>';

}

include '../in/foot.php';
?>
