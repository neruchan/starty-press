<?php
/*
 *ファイル名 : detail3.php
 * 機能名    : オーディション詳細ページ
 * 作成者    : トウ
 * 作成日    : 13/08/16
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
$template_file = "detail3.template";

$PAGE_VALUE["audition_title"] = "";
$PAGE_VALUE["audition_url"] = "";
$PAGE_VALUE["end_time"] = "";
$PAGE_VALUE["addtime"] = "";
$PAGE_VALUE["audition_new_flag"] = "";
$PAGE_VALUE["audition_text"] ="";
$PAGE_VALUE["no"] ="";
$PAGE_VALUE["aid"] ="";
session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_GET["no"]=="" || $_GET["aid"]==""){
	header('Location: main3.php');
}

$auditionData = $model_tiary_admin->selectAuditionByID($_GET["aid"]);
if(count($auditionData)>0){
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["aid"] =$_GET["aid"];
	$PAGE_VALUE["audition_title"] = $auditionData["audition_title"];
	$PAGE_VALUE["audition_url"] = $auditionData["audition_url"];
	$PAGE_VALUE["audition_text"] = nl2br($auditionData["audition_text"]);
	$PAGE_VALUE["end_time"] = $auditionData["end_time"];
	$PAGE_VALUE["addtime"] = date('Y/m/d H:s',strtotime($auditionData["addtime"]));
	$PAGE_VALUE["audition_new_flag"] =($auditionData["audition_new_flag"]==1?"&#10003;":"");
}else{
	header('Location: main3.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>