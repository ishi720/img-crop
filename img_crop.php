<?php

require 'vendor/autoload.php';
$imagine = new Imagine\Gd\Imagine();

$filename = htmlspecialchars($_GET["img_url"],ENT_QUOTES, "UTF-8");

$img_info = pathinfo($filename);

//サイズの取得
$img = $imagine->open($filename);
$size = $img->getSize();

// トリミングするサイズを決める(小さいサイズに合わせる)
$min_size = min( ($size->getWidth()) , ($size->getHeight()) ); 

// トリミングする位置を決める(中央よせ)
if ( $size->getWidth() >= $size->getHeight()) { //横幅のほうが大きい場合
    $x = $size->getWidth()/2 - $size->getHeight()/2;
    $y = 0;
} else { //縦幅のほうが大きい場合
    $x = 0;
    $y = $size->getHeight()/2 - $size->getWidth()/2;
}

$box = new Imagine\Image\Box($min_size, $min_size);
$point = new Imagine\Image\Point($x, $y);

//トリミングして表示
$imagine->open($filename)
	->crop($point, $box)
	->show($img_info['extension']);
