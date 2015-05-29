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

$template_file = "client-detail.template";

$PAGE_VALUE["edit_msg"]="";
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

if($_POST["add_flag"]!=""){
	
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
		$_DATA['client_data']['company_name'] = $_POST["company_name"];
		$_DATA['client_data']['url'] = $_POST["url"];
		$_DATA['client_data']['address1'] = $_POST["address1"];
		$_DATA['client_data']['address2'] = $_POST["address2"];
		$_DATA['client_data']['phone'] = $_POST["phone"];
		$_DATA['client_data']['email'] = $_POST["mail_address"];
		$ins_ipfDB1->dataControl("update", "id = ".$_GET["cid"]);
		unset($_DATA);
		
		$PAGE_VALUE["edit_msg"]="<br>編集完了しました！";
	}
}

$currentMonth = date("m");
$currentYear = date("Y");

$clientData = $banner_admin->selectClientByID($_GET["cid"]);
if(count($clientData)>0){
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["client_code"] =$clientData["client_code"];
	$PAGE_VALUE["company_name"] =$clientData["company_name"];
	$PAGE_VALUE["url"] =$clientData["url"];
	$PAGE_VALUE["address1"] =$clientData["address1"];
	$PAGE_VALUE["address2"] =$clientData["address2"];
	$PAGE_VALUE["phone"] =$clientData["phone"];
	$PAGE_VALUE["email"] =$clientData["email"];
	$PAGE_VALUE["id"] =$clientData['id'];
	
	$totalMoney = $banner_admin->getTotalMoneyByBannerId($clientData["client_code"]);
	$PAGE_VALUE["total"] = ($totalMoney!=""?$totalMoney:0);

	
	$valuesForLoop['historyAll'] = $banner_admin->getTotalMoneyByBannerIdBasedOnDate($clientData["client_code"]);
	
	if($valuesForLoop['historyAll'][0]['year'] == "" || $valuesForLoop['historyAll'][0]['month'] == ""){
		array_splice($valuesForLoop['historyAll'], 0, 1);
	}
	
	
	
	$valuesForLoop['bannerAll'] =  $banner_admin->getTrackDataByClientCode($clientData["client_code"]);
	
	foreach($valuesForLoop['bannerAll'] as $key => $val) {
		$valuesForLoop['bannerAll'][$key]["conversion"] = round($val["conversion"], 2)."%";
	}
	
}else{
	header('Location: banner.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>