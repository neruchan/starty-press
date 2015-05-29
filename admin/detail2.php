<?php
/*
 *ファイル名 : detail2.php
 * 機能名    : ライター詳細ページ
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
$template_file = "detail2.template";

$PAGE_VALUE["name"] = "";
$PAGE_VALUE["image"] = "";
$PAGE_VALUE["roma_name"] = "";
$PAGE_VALUE["fb_url"] = "";
$PAGE_VALUE["tw_url"] = "";
$PAGE_VALUE["blog_url"] = "";
$PAGE_VALUE["introduce"] ="";
$PAGE_VALUE["access_num"] ="";
$PAGE_VALUE["no"] ="";
$PAGE_VALUE["wid"] ="";
session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_GET["no"]=="" || $_GET["wid"]==""){
	header('Location: main2.php');
}

$writerData = $model_tiary_admin->selectWriterByID($_GET["wid"]);
if(count($writerData)>0){
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["wid"] =$_GET["wid"];
	$PAGE_VALUE["name"] = $writerData["name"];
	$PAGE_VALUE["roma_name"] = $writerData["roma_name"];
	$PAGE_VALUE["image"] = "../pjpic/".$writerData["image"];
	$PAGE_VALUE["introduce"] = nl2br($writerData["introduce"]);
	$PAGE_VALUE["fb_url"] = ($writerData["fb_url"]!=""?'<a href="'.$writerData["fb_url"].'" target="_blank">'.$writerData["fb_url"].'</a>':"");
	$PAGE_VALUE["tw_url"] = ($writerData["tw_url"]!=""?'<a href="'.$writerData["tw_url"].'" target="_blank">'.$writerData["tw_url"].'</a>':"");
	$PAGE_VALUE["blog_url"] = ($writerData["blog_url"]!=""?'<a href="'.$writerData["blog_url"].'" target="_blank">'.$writerData["blog_url"].'</a>':"");
	$PAGE_VALUE["access_num"] = $writerData["access_num"];
}else{
	header('Location: main2.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>