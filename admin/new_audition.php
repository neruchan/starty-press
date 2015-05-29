<?php
/*
 *ファイル名 : new_audition.php
 * 機能名    : オーディション新規登録ページ
 * 作成者    : トウ
 * 作成日    : 13/08/19
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
$template_file = "new_audition.template";
$PAGE_VALUE["audition_title"] = "";
$PAGE_VALUE["audition_url"] = "";
$PAGE_VALUE["end_time"] = "";
$PAGE_VALUE["audition_new_flag"] = "";
$PAGE_VALUE["audition_text"] = "";
$PAGE_VALUE["audition_new_flag_check"] = "";
$PAGE_VALUE[audition_title_err] = "";
$PAGE_VALUE[audition_url_err] = "";
$PAGE_VALUE[audition_text_err] ="";

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_POST["add_flag"]!=""){
	$error_flag = 0;
	if($_POST["audition_title"] ==""){
		$PAGE_VALUE[audition_title_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["audition_url"]){
		$PAGE_VALUE[audition_url_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["audition_text"]){
		$PAGE_VALUE[audition_text_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($error_flag !=1){
		$_DATA = array();
		$_DATA['audition']['audition_title'] = $_POST['audition_title'];
		$_DATA['audition']['audition_url'] = $_POST['audition_url'];
		$_DATA['audition']['end_time'] = $_POST["end_time"];
		if($_POST['audition_new_flag']==1){
			$_DATA['audition']['audition_new_flag'] = $_POST['audition_new_flag'];
		}
		$_DATA['audition']['audition_text'] = $_POST["audition_text"];
		$_DATA['audition']['addtime'] = date('Y-m-d H:i:s');
		$ins_ipfDB1->dataControl("insert", $_DATA);
		header('Location: main3.php');
	}else{
		$PAGE_VALUE["audition_title"] = $_POST["audition_title"];
		$PAGE_VALUE["audition_url"] = $_POST["audition_url"];
		$PAGE_VALUE["end_time"] = $_POST["end_time"];
		$PAGE_VALUE["audition_text"] = $_POST["audition_text"];
		if($_POST['audition_new_flag']==1){
			$PAGE_VALUE["audition_new_flag_check"] = 'checked="checked"';
		}
	}
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>