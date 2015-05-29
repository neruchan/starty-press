<?php
/*
 *ファイル名 : detail5.php
 * 機能名    : ランキングー詳細ページ
 * 作成者    : トウ
 * 作成日    : 13/08/09
 */

/***********************
* 定義
***********************/
require_once "tiary/ipfTemplate.php";
require_once "startypress/ipfDB1.php";
require_once "define_admin.php";
/***********************
 * コンストラクタ
***********************/
$ins_ipfTemplate = new ipfTemplate();
$ins_ipfDB1 = new ipfDB1;
$ins_ipfDB1->ini("model_tiary_admin");
/***********************
 * 画面表示処理
***********************/
$template_file = "detail5.template";

$PAGE_VALUE["shop_name"] = "";
$PAGE_VALUE["shop_image"] = "";
$PAGE_VALUE["ranking"] = "";
$PAGE_VALUE["access_num"] = "";
$PAGE_VALUE["no"] ="";
$PAGE_VALUE["sid"] ="";
session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_GET["sid"]==""){
	header('Location: main5.php');
}

$rankingData = $model_tiary_admin->selectRankingByID($_GET["sid"]);
if(count($rankingData)>0){
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["sid"] =$_GET["sid"];
	$PAGE_VALUE["shop_name"] = $rankingData["shop_name"];
	$PAGE_VALUE["ranking"] = $rankingData["ranking"];
	$PAGE_VALUE["shop_image"] = "../pjpic/".$rankingData["shop_image"];
	$PAGE_VALUE["access_num"] = $rankingData["access_num"];
	$catestr = "";
	if($rankingData["shop_category"]!=""){
		$catearr = explode(',', $rankingData["shop_category"]);
		foreach ($catearr as $key=>$val) {
			$kigou ="";
			if($key!=0)
			$kigou = ",";
			$catestr .= $kigou.$new_shop_categorys[$val];
		}
	}
	$PAGE_VALUE["shop_category"] = $catestr;
}else{
	header('Location: main5.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>