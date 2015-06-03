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
$PAGE_VALUE["tag"] = "";
$PAGE_VALUE["title"] = "";
$PAGE_VALUE["up_img"] = "";
$PAGE_VALUE["contents"] = "";
$PAGE_VALUE["links"] = "";
$PAGE_VALUE["source_name"] = "";
$PAGE_VALUE["addtime"] = "";
$PAGE_VALUE["aid"] = "";
$PAGE_VALUE["no"] = "";
$PAGE_VALUE["entry_name"] = "";
$PAGE_VALUE["client_url"] = "";
$PAGE_VALUE["client"] = "";
$PAGE_VALUE[article_img_err] = "";
$PAGE_VALUE[title_err] = "";
$PAGE_VALUE[category_err] = "";
$PAGE_VALUE[contents_err] = "";
$PAGE_VALUE[writer_id_err] = "";
$PAGE_VALUE["pay_flag_checked"] = '';
$PAGE_VALUE["postToFbChecked"] = '';
session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_GET["no"]=="" || $_GET["aid"]==""){
	header('Location: main.php');
}



$articleData = $model_tiary_admin->selectArticleByID($_GET["aid"]);
if(count($articleData)>0){
	
	$PAGE_VALUE["kiji_category_pulldown"] = setOptions($kiji_type_edit,$articleData['is_outsource']);
	
	$PAGE_VALUE["category_checkbox"] = setCheckboxArticle($new_article_categorys,$articleData["categroy"]);
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["aid"] =$_GET["aid"];
    $PAGE_VALUE["pv"] = $articleData["access_num"];
	$PAGE_VALUE["title"] = $articleData["title"];
	$PAGE_VALUE["image"] = $articleData["image"];
	$PAGE_VALUE["contents"] = $articleData["contents"];
	
	$PAGE_VALUE["links"] = $articleData["links"];
	$PAGE_VALUE["source_name"] = $articleData["source_name"];
	$PAGE_VALUE["addtime"] = date('Y/m/d H:s',strtotime($articleData["addtime"]));
}else{
	header('Location: main.php');
}

if($_POST["update_flag"]!=""){
	if($_FILES['article_img']['tmp_name'] != ''){
		$uploaddir = '/virtual/link01/public_html/startypress.jp/pjpic';
		$basename = basename($_FILES['article_img']['tmp_name']);
		$fileext = strrchr($_FILES['article_img']['name'], '.');
		$filename = $basename . $fileext;
		$uploadfile = $uploaddir . "/" . $filename;
		$is_uploaded = move_uploaded_file($_FILES['article_img']['tmp_name'], $uploadfile);
		$_POST["up_img"] = "http://startypress.jp/pjpic/".$filename;
	}

	$error_flag = 0;
	if($_POST["title"] ==""){
		$PAGE_VALUE[title_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["category"]){
		$PAGE_VALUE[category_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($_POST["contents"] ==""){
		$PAGE_VALUE[contents_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($error_flag !=1){
        
		$_DATA = array();
		$_DATA['article']['categroy'] = implode(',', $_POST['category']);
		$_DATA['article']['title'] = $_POST['title'];
		if($_POST["up_img"]!=""){
			$_DATA['article']['image'] = $_POST["up_img"];
		}
		$_DATA['article']['contents'] = $_POST['contents'];
		$_DATA['article']['terminal'] = 1;
		$_DATA['article']['links'] = $_POST["links"];
		$_DATA['article']['source_name'] = $_POST["source_name"];
       
		
        $_DATA['article']['access_num'] = $_POST["pv"];
        
		$ins_ipfDB1->dataControl("update", "id = ".$_GET["aid"]);

		header('Location: main.php');
	}else{
		$PAGE_VALUE["title"] = $_POST["title"];
		$PAGE_VALUE["contents"] = $_POST["contents"];
		$PAGE_VALUE["links"] = $_POST["links"];
		$PAGE_VALUE["entry_name"] = $_POST["entry_name"];
		
	}
}


//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>