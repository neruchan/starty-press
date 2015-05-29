<?php
/*
 *ファイル名 : new_ranking.php
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
$template_file = "new_ranking.template";
$PAGE_VALUE["shop_name"] = "";
$PAGE_VALUE["show_img"] = "img/no-img2.jpg";
$PAGE_VALUE["up_img"] = "";
$PAGE_VALUE["ranking"] = "";
$PAGE_VALUE[shop_img_err] = "";
$PAGE_VALUE[shop_name_err] = "";
$PAGE_VALUE[ranking_err] ="";
$PAGE_VALUE[shop_category_err] ="";

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$PAGE_VALUE["shop_category_checkbox"] = setCheckboxArticle($new_shop_categorys,($_POST["category"]!=""?implode(",", $_POST["category"]):$_POST["category"]));

if($_POST["add_flag"]!=""){
	if($_FILES['shop_img']['tmp_name'] != ''){
		$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
		$basename = basename($_FILES['shop_img']['tmp_name']);
		$fileext = strrchr($_FILES['shop_img']['name'], '.');
		$filename = $basename . $fileext;
		$uploadfile = $uploaddir . "/" . $filename;
		$is_uploaded = move_uploaded_file($_FILES['shop_img']['tmp_name'], $uploadfile);
		$_POST["up_img"] = $filename;
	}elseif($_POST["up_img"]==""){
		$PAGE_VALUE[shop_img_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}


	if($_POST["shop_name"] ==""){
		$PAGE_VALUE[shop_name_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["ranking"]){
		$PAGE_VALUE[ranking_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["category"]){
		$PAGE_VALUE[shop_category_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($error_flag !=1){
		$_DATA = array();
		$_DATA['shop']['shop_name'] = $_POST['shop_name'];
		$_DATA['shop']['ranking'] = $_POST['ranking'];
		$_DATA['shop']['shop_image'] = $_POST["up_img"];
		$_DATA['shop']['shop_category'] = implode(',', $_POST['category']);
		$_DATA['shop']['addtime'] = date('Y-m-d H:i:s');
		$ins_ipfDB1->dataControl("insert", $_DATA);
		header('Location: main5.php');
	}else{
		$PAGE_VALUE["shop_name"] = $_POST["shop_name"];
		$PAGE_VALUE["up_img"] = $_POST["up_img"];
		$PAGE_VALUE["show_img"] = "../pjpic/".$_POST["up_img"];
		$PAGE_VALUE["ranking"] = $_POST["ranking"];
	}
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>