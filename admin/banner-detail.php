<?php
/*
 *ファイル名 : detail.php
 * 機能名    : 記事新規登録ページ
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
$ins_ipfDB1->ini("banner_admin");
/***********************
 * 画面表示処理
***********************/

$template_file = "banner-detail.template";

$PAGE_VALUE["client"]="";
$PAGE_VALUE["title"] = "";
$PAGE_VALUE["image"] = "";
$PAGE_VALUE["contents"] = "";
$PAGE_VALUE["links"] = "";
$PAGE_VALUE["addtime"] = "";
$PAGE_VALUE["categroy"] = "";
$PAGE_VALUE["writer_name"] ="";
$PAGE_VALUE["no"] ="";
$PAGE_VALUE["aid"] ="";
$PAGE_VALUE["nickname_field"] = '';
$PAGE_VALUE["edit_btn"] = '';
$PAGE_VALUE["video_part"] = '';
$PAGE_VALUE["tag"] = "";
session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_GET["bid"]==""){
	header('Location: banner.php');
}

if($_POST['send_flag']){
	
	$_DATA = array();
	$_DATA['banner_advertising']['ba_title'] = $_POST['banner_title'];
	$_DATA['banner_advertising']['ba_url'] = $_POST['banner_url'];
	
	$ins_ipfDB1->dataControl("update", "id = ".$_POST["bid"]);
}

$currentMonth = date("m");
$currentYear = date("Y");

$valuesForLoop['historyAll'] = $banner_admin->selectClickHistoryGroupMonth($_GET["bid"]);

$bannerData = $banner_admin->selectBannerByID($_GET["bid"]);
if(count($bannerData)>0){
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["bid"] =$_GET["bid"];
	$PAGE_VALUE["title"] = $bannerData["ba_title"];
	$PAGE_VALUE["url"] = $bannerData["ba_url"];
	$PAGE_VALUE["click_num_total"] = $bannerData["click_num"];
	
	$PAGE_VALUE["current_month"] = $currentMonth."月";
	
	$historyThisMonthTotal = $banner_admin->selectClickHistoryByTime($_GET["bid"],$currentYear,$currentMonth);
	
	$PAGE_VALUE["current_month_click"] = $historyThisMonthTotal['click_num'];
	
	
	
	
}else{
	header('Location: banner.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>