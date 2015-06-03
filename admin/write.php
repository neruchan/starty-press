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
$template_file = "write.template";
$PAGE_VALUE["title"] = "";
$PAGE_VALUE["up_img"] = "";
$PAGE_VALUE["contents"] = "";
$PAGE_VALUE["links"] = "";
$PAGE_VALUE["source_name"] = "";
$PAGE_VALUE["entry_name"] = "";
$PAGE_VALUE[article_img_err] = "";
$PAGE_VALUE[title_err] = "";
$PAGE_VALUE[category_err] ="";
$PAGE_VALUE[contents_err] ="";
$PAGE_VALUE[writer_id_err] ="";

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$PAGE_VALUE["category_checkbox"] = setCheckboxArticle($new_article_categorys,($_POST["category"]!=""?implode(",", $_POST["category"]):$_POST["category"]));


if($_POST["add_flag"]!=""){
	
	$error_flag = 0;
	if($_FILES['article_img']['tmp_name'] != ''){
		$uploaddir = '/virtual/link01/public_html/startypress.jp/pjpic';
		$basename = basename($_FILES['article_img']['tmp_name']);
		$fileext = strrchr($_FILES['article_img']['name'], '.');
		$filename = $basename . $fileext;
		$uploadfile = $uploaddir . "/" . $filename;
		$is_uploaded = move_uploaded_file($_FILES['article_img']['tmp_name'], $uploadfile);
		$_POST["up_img"] = "http://startypress.jp/pjpic/".$filename;
	}else{
		$PAGE_VALUE[article_img_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	
	if($_POST["title"] ==""){
		$PAGE_VALUE[title_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	elseif(mb_strlen($_POST["title"], 'UTF-8') > 80){
		$PAGE_VALUE[title_err] ='<tr><td></td><td><p class="red">※80文字以内で入力してください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["category"]){
		$PAGE_VALUE[category_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	//$length=strlen(preg_replace('/&#[0-9a-f]{4}/', '_', $_POST["contents"]));
	if($_POST["contents"] ==""){
		$PAGE_VALUE[contents_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	
	// elseif(mb_strlen($_POST["contents"]) > 8000){
// 		$PAGE_VALUE[contents_err] ='<tr><td></td><td><p class="red">※2500文字以内で入力してください。</p></td></tr>';
// 		$error_flag = 1;
// 	}

	// if($_POST["writer_id"] ==0){
// 		$PAGE_VALUE[writer_id_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
// 		$error_flag = 1;
// 	}

	if($error_flag !=1){
	   mb_regex_encoding('UTF-8');
        mb_internal_encoding("UTF-8"); 
		$_DATA = array();
		$_DATA['article']['categroy'] = implode(',', $_POST['category']);
		$_DATA['article']['title'] = $_POST['title'];
		$_DATA['article']['image'] = $_POST["up_img"];
		$_DATA['article']['contents'] = $_POST['contents'];
		$_DATA['article']['terminal'] = 1;
		$_DATA['article']['links'] = $_POST["links"];
		$_DATA['article']['source_name'] = $_POST["source_name"];
		$_DATA['article']['addtime'] = date('Y-m-d H:i:s');
		$_DATA['article']['writer_id'] = $_POST["write_id"];
		$_DATA['article']['entry_name'] = $_POST["entry_name"];
		$_DATA['article']['pay_flag'] = $_POST["pay_flag"];
		$entry_id = $ins_ipfDB1->dataControl("insert", $_DATA);
        
		header('Location: main.php');
	}else{
		$PAGE_VALUE["title"] = $_POST["title"];
		$PAGE_VALUE["entry_name"] = $_POST["entry_name"];
		$PAGE_VALUE["up_img"] = $_POST["up_img"];
		$PAGE_VALUE["contents"] = $_POST["contents"];
		$PAGE_VALUE["links"] = $_POST["links"];
		$PAGE_VALUE["source_name"] = $_POST["source_name"];
		if($_POST["pay_flag"]==1){
			$PAGE_VALUE["pay_flag_checked"] = 'checked="checked"';
		}
		if($_POST["postToFb"]==1){
			$PAGE_VALUE["postToFbChecked"] = 'checked="checked"';
		}
	}
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>