<?php
$title = 'Lịch sử nạp thẻ';
include '../in/head.php';

if (!isset($_SESSION['user'])) {
    header('location: /index.php');
    exit;
} else {

    echo '<div class="card">
            <div class="card-body">
                <div class="col mt-5">
                    <h5 class="mt-0 mb-20"><i class="fa fa-history" aria-hidden="true"></i><b> Lịch sử nạp thẻ</b></h5>
                    <div class="table-responsive">
                        <table width="100%" class="table table-bordered" style="background: #ffecc3;">
                            <thead>
                                <tr>
                                    <th><center>Thời gian</center></th>
                                    <th><center>Mã thẻ</center></th>
                                    <th><center>Seri</center></th>
                                    <th><center>Mệnh giá</center></th>
                                    <th><center>Kết quả</center></th>
                                </tr>
                            </thead>
                            <tbody style="text-align:center">';

    $user_id = $user['id'];
    $query = "SELECT * FROM `topup` WHERE `user_id`='$user_id' ORDER BY `id` DESC LIMIT 1000";
    $result = mysqli_query($connect, $query);

    if ($result) {
        while ($info = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $info['time'] . '</td>
                    <td>' . $info['ma'] . '</td>
                    <td>' . $info['seri'] . '</td>
                    <td>' . number_format($info['vnd']) . 'đ</td>';

            if ($info['trangthai'] == 1) {
                echo '<td><font color="blue">Thành công</font></td>';
            } elseif ($info['trangthai'] == 2) {
                echo '<td><font color="red">Sai mệnh giá -100%</font></td>';
            } elseif ($info['trangthai'] == 3) {
                echo '<td><font color="red">Sai mã thẻ hoặc seri</font></td>';
            } elseif ($info['trangthai'] == 99) {
                echo '<td><font color="red">Chờ xử lý #2</font></td>';
            } elseif ($info['trangthai'] == 999) {
                echo '<td><font color="red">Sai mã hoặc seri</font></td>';
            } else {
                echo '<td><font color="red">Đang gạch...</font></td>';
            }

            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">Không có dữ liệu</td></tr>';
    }

    echo '</tbody>
            </table>
        </div>
    </div>
</div>
</div>';

}

include '../in/foot.php';
?>
