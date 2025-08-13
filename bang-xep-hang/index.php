<?php
include '../in/head.php';

echo '<div class="container pb-5 card">
    <div class="row">
        <div class="col-md-12">';

echo '<div class="text text-dark text-left mt-2">
					<h4 class="ml-2 text-left">BẢNG XẾP HẠNG ĐẠI GIA <i class="fa fa-money"></i></h4>
				</div>
				
 <table class="table table-bordered">
                <thead>
                <tr>
                    <td>Nhân Vật</td>
                    <td>Điểm</td>
                  
                </tr>
                </thead>
                <tbody>';


// Query và hiển thị bảng xếp hạng đại gia
$query_tongnap = "SELECT * FROM `player` WHERE `tongnap` > '0' AND `characterName` != '' ORDER BY `tongnap` DESC LIMIT 10";
$result_tongnap = $connect->query($query_tongnap);
$i = 1;
while ($info = $result_tongnap->fetch_assoc()) {
    echo '<tr>
            <th>
                <span class="fa-stack">
                    <span class="fa fa-circle fa-stack-2x color color_1"></span>
                    <strong class="fa-stack-1x" style="color:white;">' . $i . '</strong>
                </span> ' . $info['characterName'] . '</th>
            <th width="50%"><a class="btn btn-outline-info">' . number_format($info['tongnap']) . 'đ</a></th>
        </tr>';
    $i++;
}

echo '</tbody>
</table>';

echo '<div class="text text-dark text-left mt-2">
					<h4 class="ml-2 text-left">BẢNG XẾP HẠNG CAO THỦ LEVEL <i class="fa fa-fire"></i></h4>
				</div>
				
 <table class="table table-bordered">
                <thead>
                <tr>
                    <td>Nhân Vật</td>
                    <td>Level</td>
                  
                </tr>
                </thead>
                <tbody>';


// Query và hiển thị bảng xếp hạng cao thủ level
$query_top_level = "SELECT * FROM `player` WHERE `top-level` > '0' AND `characterName` != '' ORDER BY `top-level` DESC LIMIT 10";
$result_top_level = $connect->query($query_top_level);
$i = 1;
while ($info = $result_top_level->fetch_assoc()) {
    echo '<tr>
            <th>
                <span class="fa-stack">
                    <span class="fa fa-circle fa-stack-2x color color_1"></span>
                    <strong class="fa-stack-1x" style="color:white;">' . $i . '</strong>
                </span> ' . $info['characterName'] . '</th>
            <th width="50%"><a class="btn btn-outline-info">Level ' . number_format($info['top-level']) . '</a></th>
        </tr>';
    $i++;
}

echo '</tbody>
</table>';

echo '
        </div>
    </div>
</div>';

include '../in/foot.php';
?>
