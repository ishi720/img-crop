<?php

require 'vendor/autoload.php';
$imagine = new Imagine\Gd\Imagine();

$filename = htmlspecialchars($_GET["img_url"],ENT_QUOTES, "UTF-8");

//比率
$ratio_x = isset( $_GET["ratio_x"] ) && is_numeric($_GET["ratio_x"]) ? $_GET["ratio_x"] : 1;
$ratio_y = isset( $_GET["ratio_y"] ) && is_numeric($_GET["ratio_y"]) ? $_GET["ratio_y"] : 1;

//画像の情報を取得する
$img_info = pathinfo($filename);


//サイズの取得
$img = $imagine->open($filename);
$size = $img->getSize();
if ($ratio_x < $ratio_y){
	//縦比率のほうが大きい場合
	if($size->getWidth() >= $size->getHeight()){
		$corp_w = $size->getHeight() / ($ratio_y / $ratio_x);
		$corp_h = $size->getHeight();
	} else {
		$corp_w = $size->getWidth();
		$corp_h = $size->getWidth() * ($ratio_y / $ratio_x);
		if ($size->getHeight() < $corp_h) {
			$corp_w = $size->getHeight() / ($ratio_y / $ratio_x);	
			$corp_h = $size->getHeight();
		}
	}
} else if($ratio_x > $ratio_y) { 
	//横比率のほうが大きい場合
	if($size->getWidth() >= $size->getHeight()){
		$corp_w = $size->getHeight() * ($ratio_x / $ratio_y);
		$corp_h = $size->getHeight();
		if ($size->getWidth() < $corp_w) {
			$corp_w = $size->getWidth();	
			$corp_h = $size->getWidth() / ($ratio_x / $ratio_y);
		}
	} else {
		$corp_w = $size->getWidth();
		$corp_h = $size->getWidth() / ($ratio_x / $ratio_y);
	}
} else {
	//比率が同じ場合
	$corp_w = min( ($size->getWidth()) , ($size->getHeight()) );
	$corp_h = min( ($size->getWidth()) , ($size->getHeight()) );
}


// トリミングする位置を決める(中央よせ)
$x = $size->getWidth()/2 - $corp_w/2;
$y = $size->getHeight()/2 -$corp_h/2;

$box = new Imagine\Image\Box($corp_w, $corp_h);
$point = new Imagine\Image\Point($x, $y);

//トリミングして表示
$imagine->open($filename)
	->crop($point, $box)
	->show($img_info['extension']);
