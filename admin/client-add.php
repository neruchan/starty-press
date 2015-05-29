<?php
/*
 *ファイル名 : main4.php
 * 機能名    : バーナー管理ページ
 * 作成者    : トウ
 * 作成日    : 13/08/20
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
$ins_ipfDB1->ini("banner_admin");
/***********************
 * 画面表示処理
***********************/
$template_file = "client-add.template";

$client_code_temp = "C00000".generateRandomString();

$PAGE_VALUE["client_code"]=$client_code_temp;
$PAGE_VALUE["company_name"]=$_POST["company_name"];
$PAGE_VALUE["address1"]=$_POST["address1"];
$PAGE_VALUE["address2"]=$_POST["address2"];
$PAGE_VALUE["phone"]=$_POST["phone"];
$PAGE_VALUE["mail_address"]=$_POST["mail_address"];

$PAGE_VALUE["url"]=$_POST["url"];
$PAGE_VALUE["client_code_err"]="";
$PAGE_VALUE["company_name_err"]="";
$PAGE_VALUE["phone_err"]="";
$PAGE_VALUE["email_err"]="";
$PAGE_VALUE["address_err"]="";

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

//sessionリセット
unset($_SESSION["sess_a_category"]);
unset($_SESSION["sess_writer"]);
unset($_SESSION["sess_a_addtime"]);
unset($_SESSION["sess_a_num"]);
unset($_SESSION["sess_shop_categroy"]);
unset($_SESSION["sess_shop_access"]);
unset($_SESSION["sess_audition_time"]);
unset($_SESSION["sess_userid"]);
unset($_SESSION["sess_nickname"]);


if($_POST["add_flag"]!=""){
	if($_POST["client_code"] ==""){
		$PAGE_VALUE["client_code_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($_POST["company_name"]==""){
		$PAGE_VALUE["company_name_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	
	if($_POST["phone"]==""){
		$PAGE_VALUE["phone_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	else{
		if(!preg_match("/^[0-9\-]+$/", $_POST["phone"])){
			$PAGE_VALUE["phone_err"] ='<tr><td></td><td><p class="red">正しく入力してください。</p>';
			$error_flag = 1;
		}
	}
	
	if($_POST["mail_address"]==""){
		$PAGE_VALUE["email_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	else{
		if($_POST["mail_address"] !=""){
			if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_POST["mail_address"])){
				$PAGE_VALUE["email_err"] ='<tr><td></td><td><p class="red">正しく入力してください。</p>';
				$error_flag = 1;
			}
		}
	}
	
	if($_POST["address1"]=="" && $_POST["address2"]=="" ){
		$PAGE_VALUE["address_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	
	

	if($error_flag!=1){
		unset($_DATA);
		$_DATA = array();
		$_DATA['client_data']['client_code'] = $_POST["client_code"];
		$_DATA['client_data']['company_name'] = $_POST["company_name"];
		$_DATA['client_data']['url'] = $_POST["url"];
		$_DATA['client_data']['address1'] = $_POST["address1"];
		$_DATA['client_data']['address2'] = $_POST["address2"];
		$_DATA['client_data']['phone'] = $_POST["phone"];
		$_DATA['client_data']['email'] = $_POST["mail_address"];
		$_DATA['client_data']['addtime'] = date("Y-m-d H:i:s");
		$ins_ipfDB1->dataControl("insert", $_DATA);
		unset($_DATA);
		header('Location: client.php');
	}else{

	}
}

function generateRandomString($length = 10) {
    return substr(str_shuffle("0123456789"), 0, $length);
}


//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>