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
$template_file = "banner-add.template";
$PAGE_VALUE["ba_title"]=$_POST["ba_title"];
$PAGE_VALUE["ba_url"]=$_POST["ba_url"];
$PAGE_VALUE["ba_client"]=$_POST["ba_client"];
$PAGE_VALUE["ba_url_err"]="";
$PAGE_VALUE["ba_title_err"]="";
$PAGE_VALUE["ba_client_err"]="";

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


if($_POST["save_flag"]!=""){
	if($_POST["ba_title"] ==""){
		$PAGE_VALUE["ba_title_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($_POST["ba_url"]==""){
		$PAGE_VALUE["ba_url_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	
	if($_POST["ba_client"]==""){
		$PAGE_VALUE["ba_client_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	else{
		if(!$banner_admin->selectClientByClientCode($_POST["ba_client"])){
			$PAGE_VALUE["ba_client_err"] ='<tr><td></td><td><p class="red">※クライアントデーター見つかりません。</p></td></tr>';
			$error_flag = 1;
		}
	}
	

	if($error_flag!=1){
		$client_data = $banner_admin->selectClientByClientCode($_POST["ba_client"]);
		
		unset($_DATA);
		$_DATA = array();
		$_DATA['banner_advertising']['ba_title'] = $_POST["ba_title"];
		$_DATA['banner_advertising']['client_id'] = $client_data['id'];
		$_DATA['banner_advertising']['ba_url'] = $_POST["ba_url"];
		$_DATA['banner_advertising']['addtime'] = date("Y-m-d H:i:s");
		$ins_ipfDB1->dataControl("insert", $_DATA);
		unset($_DATA);
		header('Location: banner.php');
	}else{

	}
}



//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>