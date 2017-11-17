<?php

$filename = htmlspecialchars($_GET["img_url"],ENT_QUOTES, "UTF-8");
$img = imagecreatefromjpeg($filename);

//サイズの取得
$img_w = imagesx($img);
$img_h = imagesy($img);

// トリミングするサイズを決める(小さいサイズに合わせる)
$min_size = min($img_w, $img_h); 

// トリミングする位置を決める(中央よせ)
if ( $img_w >= $img_h ) { //横幅のほうが大きい場合
    $x = $img_w/2 - $img_h/2;
    $y = 0;
} else { //縦幅のほうが大きい場合
    $x = 0;
    $y = $img_h/2 - $img_w/2;
}

//トリミングする
$crop_img = imagecrop($img, ['x' => $x, 'y' => $y, 'width' => $min_size, 'height' => $min_size]);

header("Content-Type: image/jpeg");

//出力
if ($crop_img !== FALSE) {
    imagejpeg($crop_img);
}
exit;
