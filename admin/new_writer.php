<?php
/*
 *ファイル名 : new_writer.php
 * 機能名    : ライター新規登録ページ
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
$ins_ipfDB1->ini("model_tiary_admin");
/***********************
 * 画面表示処理
***********************/
$template_file = "new_writer.template";
$PAGE_VALUE["name"] = "";
$PAGE_VALUE["show_img"] = "img/no-img2.jpg";
$PAGE_VALUE["up_img"] = "";
$PAGE_VALUE["roma_name"] = "";
$PAGE_VALUE["fb_url"] = "";
$PAGE_VALUE["tw_url"] = "";
$PAGE_VALUE["blog_url"] = "";
$PAGE_VALUE["introduce"] = "";
$PAGE_VALUE[writer_img_err] = "";
$PAGE_VALUE[name_err] = "";
$PAGE_VALUE[introduce_err] ="";

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_POST["add_flag"]!=""){
	if($_FILES['writer_img']['tmp_name'] != ''){
		$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
		$basename = basename($_FILES['writer_img']['tmp_name']);
		$fileext = strrchr($_FILES['writer_img']['name'], '.');
		$filename = $basename . $fileext;
		$uploadfile = $uploaddir . "/" . $filename;
		$is_uploaded = move_uploaded_file($_FILES['writer_img']['tmp_name'], $uploadfile);
		$_POST["up_img"] = $filename;
	}elseif($_POST["up_img"]==""){
		$PAGE_VALUE[writer_img_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	$error_flag = 0;
	if($_POST["name"] ==""){
		$PAGE_VALUE[name_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["introduce"]){
		$PAGE_VALUE[introduce_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($error_flag !=1){
		$_DATA = array();
		$_DATA['writer']['name'] = $_POST['name'];
		$_DATA['writer']['roma_name'] = $_POST['roma_name'];
		$_DATA['writer']['image'] = $_POST["up_img"];
		$_DATA['writer']['fb_url'] = $_POST['fb_url'];
		$_DATA['writer']['blog_url'] = $_POST["blog_url"];
		$_DATA['writer']['tw_url'] = $_POST["tw_url"];
		$_DATA['writer']['addtime'] = date('Y-m-d H:i:s');
		$_DATA['writer']['introduce'] = $_POST["introduce"];
		$ins_ipfDB1->dataControl("insert", $_DATA);
		header('Location: main2.php');
	}else{
		$PAGE_VALUE["name"] = $_POST["name"];
		$PAGE_VALUE["up_img"] = $_POST["up_img"];
		$PAGE_VALUE["show_img"] = "../pjpic/".$_POST["up_img"];
		$PAGE_VALUE["roma_name"] = $_POST["roma_name"];
		$PAGE_VALUE["fb_url"] = $_POST["fb_url"];
		$PAGE_VALUE["tw_url"] = $_POST["tw_url"];
		$PAGE_VALUE["blog_url"] = $_POST["blog_url"];
		$PAGE_VALUE["introduce"] = $_POST["introduce"];
	}
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>