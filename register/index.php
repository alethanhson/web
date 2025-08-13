<?php
$title = 'Đăng nhập';
include '../in/func.php';
include '../in/head.php';

// Lock đăng kí
$lock = false;

if ($user) {
    echo '<meta http-equiv="refresh" content="0;url=/">';
    exit;
}

echo '<style>
        .form-signin {
            width: 100%;
            max-width: 400px;
            padding: 15px 0;
            margin: 0 auto;
        }
    </style>';
echo '<body class="">
    <div class="container pb-5">
        <form class="form-signin" method="POST">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-3 font-weight-normal text-center">Tạo tài khoản</h1>';

if ($_SESSION['ref']) {
    echo '<font color="green">Mã giới thiệu ID: #' . $_SESSION['ref'] . '</font><br/>';
}

if (isset($_POST['submit'])) {
    $users = mysqli_real_escape_string($connect, mb_strtolower($_POST['tk']));
    $users = strtolower($users);
    $users = str_replace(' ', '', $users);
    $pass = mysqli_real_escape_string($connect, $_POST['mk']);
    $pass = strtolower($pass);
    $pass = str_replace(' ', '', $pass);
    $sdt = mysqli_real_escape_string($connect, $_POST['phone']);
    $sdt = str_replace(' ', '', $sdt); // Loại bỏ khoảng trắng

    // Kiểm tra xem đó có phải là số điện thoại hợp lệ không
    $pattern = '/^(03|05|07|08|09|01[2|6|8|9])[0-9]{8}$/';

    if (!$users || !$pass || !$sdt) {
        echo '<span style="color: red; font-size: 12px; font-weight: bold;">Vui lòng điền đầy đủ thông tin.</span>';
    } elseif ($lock) {
        echo '<span style="color: red; font-size: 12px; font-weight: bold;">Đăng kí chưa mở. Tham gia Cộng đồng để cập nhật thông tin mới nhất.</span>';
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $users)) {
        echo '<span style="color: red; font-size: 12px; font-weight: bold;">Tên đăng nhập không được phép có kí tự đặc biệt.</span>';
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $pass)) {
        echo '<span style="color: red; font-size: 12px; font-weight: bold;">Mật khẩu không được phép có kí tự đặc biệt.</span>';
    } elseif (!preg_match($pattern, $sdt)) {
        echo '<span style="color: red; font-size: 12px; font-weight: bold;">Số điện thoại không hợp lệ.</span>';
    } else {
        $query = "SELECT username FROM player WHERE username='" . $users . "'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<span style="color: red; font-size: 12px; font-weight: bold;">Tài khoản này đã tồn tại.</span>';
        } elseif (mb_strlen($users, 'UTF-8') < 5 || mb_strlen($user, 'UTF-8') > 20) {
            echo '<span style="color: red; font-size: 12px; font-weight: bold;">Tài khoản phải có độ dài từ 5 - 20 kí tự</span>';
        } elseif (mb_strlen($pass, 'UTF-8') < 5) {
            echo '<span style="color: red; font-size: 12px; font-weight: bold;">Mật khẩu quá ngắn.</span>';
        } else {
            $insert_query = "INSERT INTO player(`username`, `password`, `mobile`, `vnd`) VALUES ('" . $users . "','" . $pass . "','" . $sdt . "','10000000')";
            mysqli_query($connect, $insert_query);

            if ($_SESSION['ref']) {
                $ref_query = "SELECT * FROM `player` WHERE `id`='" . $_SESSION['ref'] . "' LIMIT 1";
                $ref_result = mysqli_query($connect, $ref_query);
                $uref = mysqli_fetch_array($ref_result);
                
                if ($uref) {
                    $update_query = "UPDATE `player` SET `ref_id`='" . $uref['id'] . "' WHERE `username` = '" . $users . "'";
                    mysqli_query($connect, $update_query);
                }
            }

            $_SESSION['user'] = $users;
            echo '<meta http-equiv="refresh" content="0;url=/">';
            echo '<span style="color: green; font-size: 12px; font-weight: bold;">Đăng ký thành công.</span>';
        }
        echo '<br>';
    }
}

echo '<label>Tài khoản:</label>
      <input type="text" name="tk"  class="form-control" placeholder="Tên tài khoản ..." required="" autofocus=""><br>
      <label>Mật khẩu:</label>
      <input type="password" name="mk" class="form-control" placeholder="Mật khẩu ..." required=""><br>
      <label>Số điện thoại:</label>
      <input type="number" name="phone" class="form-control mb-2" placeholder="Số điện thoại ..." required="">
      <br>
      <div class="form-group text-center">
        <button class="btn btn-lg btn-dark btn-block" style="border-radius: 10px;" type="submit" name="submit">Tạo tài khoản</button>
      </div>  
    </form>
  </div>
</div>
</body>';

include '../in/foot.php';
?>
