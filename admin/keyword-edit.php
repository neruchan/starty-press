<?php
/*
 * ファイル名 : edit.php
 * 機能名     : 記事編集ページ
 * 作成者     : トウ
 * 作成日     : 13/08/09
 */

/***********************
* 定義
***********************/
require_once "tiary/ipfTemplate.php";
require_once "startypress/ipfDB1.php";
require_once "define_admin.php";
require_once 'src/facebook.php';
/***********************
 * コンストラクタ
***********************/
$ins_ipfTemplate = new ipfTemplate();
$ins_ipfDB1 = new ipfDB1;
$ins_ipfDB1->ini("model_tiary_admin");
/***********************
 * 画面表示処理
***********************/
$template_file = "keyword-edit.template";

$PAGE_VALUE["keyword"] = "";
$PAGE_VALUE["display"] = "";

$PAGE_VALUE["keyword_err"] = "";
$PAGE_VALUE["display_err"] = "";

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$keywordData = $model_tiary_admin->selectKeywordByID($_GET["kid"]);
if(count($keywordData)>0){
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["kid"] =$_GET["kid"];
	$PAGE_VALUE["keyword"] = $keywordData["keyword"];
	$PAGE_VALUE["display"] = $keywordData["display"];
}else{
	header('Location: keyword.php');
}


if($_POST["update_flag"]!=""){
	
	$error_flag = 0;
	

	
	if($_POST["keyword"] ==""){
		$PAGE_VALUE[keyword_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	elseif(mb_strlen($_POST["keyword"], 'UTF-8') > 80){
		$PAGE_VALUE[keyword_err] ='<tr><td></td><td><p class="red">※80文字以内で入力してください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["display"]){
		$PAGE_VALUE[display_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}


	

	if($error_flag !=1){
		
		$_DATA = array();
		$_DATA['search_keyword_display']['keyword'] = $_POST["keyword"];
		$_DATA['search_keyword_display']['display'] = $_POST['display'];
		
		$ins_ipfDB1->dataControl("update", "id = ".$_GET["kid"]);
	
		
		header('Location: keyword.php');
	}else{
		$PAGE_VALUE["keyword"] = $_POST["keyword"];
		$PAGE_VALUE["display"] = $_POST["display"];
	}
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>