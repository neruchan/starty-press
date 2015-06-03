<?php
/*
* ファイル名 : pickup.php
* 機能名   : ピックアップ一覧ページ
* 作成者   : NELSON
* 作成日   : 2015/6/01
*/

/***********************
 * 定義
***********************/
require_once "tiary/ipfTemplate.php";
require_once "startypress/ipfDB1.php";
/***********************
 * コンストラクタ
***********************/
$ins_ipfTemplate = new ipfTemplate();
$ins_ipfDB1 = new ipfDB1;
$ins_ipfDB1->ini("starty_press");
/***********************
 * 画面表示処理
 ***********************/
//共通処理
session_start();
$template_file = "read.template";

require_once "define.php";

$PAGE_VALUE["article_title"] = "";
$PAGE_VALUE["article_image"] = "";
$PAGE_VALUE["article_categroy"] = "";
$PAGE_VALUE["article_entry_name"] = "";
$PAGE_VALUE["article_addtime"] = "";
$PAGE_VALUE["article_contents"] = "";
$PAGE_VALUE["article_name"] = "";
$PAGE_VALUE["article_access_num"] = "";
$PAGE_VALUE["article_links"] = "";

$PAGE_VALUE["isPostedByUser_start"] = "<!--";
$PAGE_VALUE["isPostedByUser_end"] = "-->";

$PAGE_VALUE['profile_img'] = "";
$PAGE_VALUE['nickname'] = "";

$PAGE_VALUE['user_add_flag'] = '';
$PAGE_VALUE['user_add_flag_img'] = '';
$PAGE_VALUE['bookmark_add_flag'] = '';
$PAGE_VALUE['bookmark_add_flag_class'] = '';

$PAGE_VALUE['bookmark_add_img'] ="";
$PAGE_VALUE['user_add_flag_js'] = "";
$PAGE_VALUE['bookmark_add_url_js'] ="";
$PAGE_VALUE['addUser'] = "";
$PAGE_VALUE['css_id_user_press'] = "";
$PAGE_VALUE['tag'] = "";
$PAGE_VALUE['tag_string'] = "";

if($_GET["aid"]==""){
	header('Location: index.php');
}

$PAGE_VALUE["article_id"] = $_GET["aid"];


//アクセス数変更
//記事ランキング
$ins_ipfDB1->disconnect;
		
$ins_ipfDB1 = new ipfDB1;

$articleData = $starty_press->selectArticleByID($_GET["aid"]);
if(count($articleData)>0){
	$PAGE_VALUE["article_title"] = $articleData["title"];
	$PAGE_VALUE["article_entry_name"] = ($articleData["entry_name"]!=""?'/ 提供：'.$articleData["entry_name"]:"");
	$PAGE_VALUE["article_addtime"] = date('Y.m.d',strtotime($articleData["addtime"]));
	$PAGE_VALUE["article_access_num"] = $articleData["access_num"];
	$PAGE_VALUE["article_contents"] = nl2br($articleData["contents"]);
	$PAGE_VALUE["article_image"] = '<img src="'.$articleData["image"].'" alt="" width="300" />';
	$currentCategory = $articleData["categroy"];
	if($articleData["categroy"]!="" && $articleData["categroy"]!="0"){
		$category  ="";
		$categoryArr = explode(',', $articleData["categroy"]);
		foreach ($categoryArr as $value) {
			$PAGE_VALUE["cat_link"] = $article_links[$value];
			$category .= $article_categroys[$value]." ";
		}
		$PAGE_VALUE["article_categroy"] = $category;
	}
}
else{
	header('Location: index.php');
}


$ipAddress = get_client_ip();
// echo "current ip address is = ".$ipAddress;

$ipData = $starty_press->checkIp($ipAddress);


if(!$ipData){
	unset($_DATA);
	$_DATA = array();
	$_DATA['visitor_ip']['ip_address'] = $ipAddress;
	$_DATA['visitor_ip']['addtime'] = date("Y-m-d H:i:s");
	$ipDataId = $ins_ipfDB1->dataControl("insert", $_DATA);
}
else{
	$ipDataId = $ipData['id'];
}


$accessData = $starty_press->checkAccesstimeByIP($ipDataId,$_GET["aid"]);

if($accessData){
	if( strtotime('-1 days') > strtotime($accessData['addtime']) ) {
		//echo "udah lewat sehari";
		$starty_press->selectUpdateAccessByID($_GET["aid"]);
		unset($_DATA);
		$_DATA = array();
		$_DATA['ip_article']['addtime'] = date("Y-m-d H:i:s");
		$ins_ipfDB1->dataControl("update", "id = ".$accessData['id']);
	}
}
else{
	unset($_DATA);
	$_DATA = array();
	$_DATA['ip_article']['ipid'] = $ipDataId;
	$_DATA['ip_article']['aid'] = $_GET["aid"];
	$_DATA['ip_article']['addtime'] = date("Y-m-d H:i:s");
	$entry_id = $ins_ipfDB1->dataControl("insert", $_DATA);
	
	$starty_press->selectUpdateAccessByID($_GET["aid"]);
}


//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();


?>