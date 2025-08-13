<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="vi">
    
<head>
    <title>Làng Lá Plus</title>
    <meta charset="utf-8">
    <meta name="robots" content="none"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://langlaplus.com"/>
    <meta property="og:title" content="Làng Lá Plus"/>
    <meta property="og:description" content="Làng lá Plus phiên bản Private - Tựa game nhập vai Manga kinh điển gắn liền với tuổi thơ của vô số game thủ."/>
    <meta property="og:image" content="https://i.imgur.com/JOpxvzS.png"/>
    <link rel="shortcut icon" href="/images/LangLa.ico" type="image/x-icon">
    <meta name="description" content="Làng lá Plus phiên bản Private - Tựa game nhập vai Manga kinh điển gắn liền với tuổi thơ của vô số game thủ.">
    <meta name="keywords" content="lang la lau, lang la private, làng lá phiêu lưu ký, làng lá, làng lá lậu">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/css/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    

<style>
    .swal2-popup {
        font-size: 1.0rem;
    }
</style>

    
</head>

<div class="container main">


<div class="text-center card">
                <div class="card-body">
                    <a href="/">
                        <div class="text-center">
                            <img class="nsotien_logo" alt="Logo" src="/images/logo.png" style="display: block;margin-left: auto;margin-right: auto;max-width: 188px;">
                        </div>
                    </a>

                </div>



   <div class="">
                    <div class="">
                

<?php
// Kiểm tra biến $user trước khi sử dụng
if(isset($user) && $user){
echo'<font color="green">Tài khoản: </font><b><font color="red">'.$user['username'].'</b> </font> |<font color="green"> Số dư hiện tại: </font><b><font color="red">'.number_format($user['vnd']).'đ </b> </font>

<br><br>

<font color="green">Quy đổi tiền đã nạp sang vàng tại NPC Ngân Khố Quan</font> <br>
<span class="abc px-2 py-1 fw-semibold btn btn-danger y-75 rounded-2 cursor-pointer">
<a class=" text-white" href="/nap-tien"><i class="fa fa-money"></i> Nạp tiền </span></a>
</span>

<span class="abc px-2 py-1 fw-semibold btn btn-danger y-75 rounded-2 cursor-pointer">
<a class=" text-white" href="/lich-su"><i class="fa fa-history"></i> Lịch sử nạp  </span></a>
</span>

<span class="abc px-2 py-1 fw-semibold btn btn-danger y-75 rounded-2 cursor-pointer">
<a class=" text-white" href="/exit.php"><i class="fa fa-sign-out"></i> Đăng xuất  </span></a>
</span>


                  </div>';
} else {
echo'                
                       
                        
<span class="abc px-2 py-1 fw-semibold btn btn-danger y-75 rounded-2 cursor-pointer">
<a class=" text-white" href="/login"><i class="fa fa-sign-in"></i> Đăng nhập</a>
</span>
<span class="abc ms-2 px-2 py-1  text-white fw-semibold  btn btn-danger rounded-2 cursor-pointer">
<a class=" text-white" href="/register"><i class="fa fa-user-plus"></i> Tạo tài khoản</a>
</span>

</div>

';
}




?>


<div class="mt-3">
                        <a class="mb-3 px-2 py-1 fw-semibold btn btn-success rounded-2 cursor-pointer" href="/tai-ve"><i class="fa fa-download" aria-hidden="true"></i> TẢI GAME </a>

                                            </div>

                </div>
            </div>









<div class="row text-center justify-content-center row-cols-2 row-cols-lg-6 g-2 g-lg-2 my-1 mb-2">
                <div class="col">
                    <div class="px-2"><a class="btn btn-menu btn-danger w-100 fw-semibold false" href="/"><i class="fa fa-home"></i> Trang
                            Chủ</a></div>
                </div>
                <div class="col">
                    <div class="px-2"><a class="btn btn-menu btn-danger w-100 fw-semibold false" href="https://www.facebook.com/langlaplus.official"><i class="fa fa-facebook-square"></i> Fan Page</a></div>
                </div>

                <div class="col">
                    <div class="px-2">
                        <a class="btn btn-menu btn-danger w-100 fw-semibold" href="/community"><i class="fa fa-users" aria-hidden="true"></i> Cộng Đồng</a>
                    </div>
                </div>
               
                <div class="col">
                    <div class="px-2">
                        <a class="btn btn-menu btn-danger w-100 fw-semibold" href="/bang-xep-hang"><i class="fa fa-users" aria-hidden="true"></i> BXH</a>
                    </div>
                </div>
               

            </div>








