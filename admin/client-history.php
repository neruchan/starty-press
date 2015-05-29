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

$template_file = "client-history.template";

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

$PAGE_VALUE["client_code_err"]="";
$PAGE_VALUE["company_name_err"]="";
$PAGE_VALUE["phone_err"]="";
$PAGE_VALUE["email_err"]="";
$PAGE_VALUE["address_err"]="";


session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_GET["cid"]==""){
	header('Location: client.php');
}


$currentMonth = $_GET['m'];
$currentYear = $_GET['y'];

$clientData = $banner_admin->selectClientByID($_GET["cid"]);
if(count($clientData)>0){
	
	$PAGE_VALUE["year"] = $currentYear;
	$PAGE_VALUE["month"] = $currentMonth;
	
	$PAGE_VALUE["id"] =$clientData['id'];

	
	$valuesForLoop['historyAll'] = $banner_admin->getTotalMoneyByBannerIdBasedOnYearMonth($clientData["client_code"],$currentYear, $currentMonth);
	
	
}else{
	header('Location: banner.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>