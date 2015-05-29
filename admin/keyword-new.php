<?php
/*
 *ファイル名 : write.php
 * 機能名    : 記事新規登録ページ
 * 作成者    : トウ
 * 作成日    : 13/08/09
 */

/***********************
* 定義
***********************/
require_once "tiary/ipfTemplate.php";
require_once "startypress/ipfDB1.php";
require_once 'src/facebook.php';
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
$template_file = "keyword-new.template";
$PAGE_VALUE["keyword"] = "";
$PAGE_VALUE["display"] = "";

$PAGE_VALUE["keyword_err"] = "";
$PAGE_VALUE["display_err"] = "";

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}



if($_POST["add_flag"]!=""){
	
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
		$_DATA['search_keyword_display']['addtime'] = date("Y-m-d H:i:s");
		$entry_id = $ins_ipfDB1->dataControl("insert", $_DATA);
		
		
	
		
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