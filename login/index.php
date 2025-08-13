<?php
$title = 'Đăng nhập';
include '../in/head.php';

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
                    <h1 class="h3 mb-3 font-weight-normal text-center">Đăng nhập</h1>';

if (isset($_POST['submit'])) {
    $users = mysqli_real_escape_string($connect, mb_strtolower($_POST['tk']));
    $users = strtolower($users);
    $users = str_replace(' ', '', $users);
    $pass = mysqli_real_escape_string($connect, $_POST['mk']);
    $pass = strtolower($pass);
    $pass = str_replace(' ', '', $pass);

    if (!$users || !$pass) {
        echo '<span style="color: red; font-size: 12px; font-weight: bold;">Nhập đầy đủ thông tin.</span>';
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $users)) {
        echo '<span style="color: red; font-size: 12px; font-weight: bold;">Thông tin đăng nhập không chính xác</span>';
    } else {
        $query = "SELECT * FROM `player` WHERE `username`='" . $users . "' LIMIT 1";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if ($pass != $user_data['password']) {
                echo '<span style="color: red; font-size: 12px; font-weight: bold;">Mật khẩu không chính xác</span>';
            } elseif ($user_data['role'] == 0) {
                echo '<span style="color: red; font-size: 12px; font-weight: bold;">Tài khoản đã bị khóa bởi Admin</span>';
            } else {
                $_SESSION['user'] = $user_data['username'];
                echo '<meta http-equiv="refresh" content="0;url=/">';
                echo '<span style="color: green; font-size: 12px; font-weight: bold;">Đăng nhập thành công.</span>';
            }
        } else {
            echo '<span style="color: red; font-size: 12px; font-weight: bold;">Thông tin đăng nhập không chính xác</span>';
        }
    }
    echo '<br>';
}

echo '<form class="form-signin" method="POST">
            <label>Tài khoản:</label>
            <input type="text" name="tk" class="form-control" placeholder="Tên tài khoản..." required="" autofocus=""><br>
            <label>Mật khẩu:</label>
            <input type="password" name="mk" class="form-control" placeholder="Mật khẩu..." required=""><br>
            <div class="form-group text-center">
                <button class="btn btn-lg btn-info btn-block text-white" style="border-radius: 10px;" type="submit" name="submit">Đăng nhập</button>
            </div>  
        </form>
    </div>
</div>
</body>';

include '../in/foot.php';
?>
