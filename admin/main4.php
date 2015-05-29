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
$template_file = "main4.template";
$PAGE_VALUE["ba_title"]=$_POST["ba_title"];
$PAGE_VALUE["ba_url"]=$_POST["ba_url"];
$PAGE_VALUE["time_err"]="";
$PAGE_VALUE["banner_img_err"]="";
$PAGE_VALUE["banner_img_err2"]="";
$PAGE_VALUE["banner_img_err3"]="";
$PAGE_VALUE["ba_url_err"]="";
$PAGE_VALUE["ba_title_err"]="";

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$PAGE_VALUE["start_year_pulldown"] = setOptions($open_years,$_POST["ba_start_y"]);

$PAGE_VALUE["start_month_pulldown"] = setOptions($open_months,$_POST["ba_start_m"]);

$PAGE_VALUE["start_day_pulldown"] = setOptions($open_days,$_POST["ba_start_d"]);

$PAGE_VALUE["end_year_pulldown"] = setOptions($open_years,$_POST["ba_end_y"]);

$PAGE_VALUE["end_month_pulldown"] = setOptions($open_months,$_POST["ba_end_m"]);

$PAGE_VALUE["end_day_pulldown"] = setOptions($open_days,$_POST["ba_end_d"]);

$PAGE_VALUE["part_flag_pulldown"] = setOptions($part_flags,$_POST["part_flag"]);

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

$bannerData1 = $model_tiary_admin->selectBannerByID(1);

$bannerData2 = $model_tiary_admin->selectBannerByID(2);

$bannerData3 = $model_tiary_admin->selectBannerByID(3);
if(count($bannerData1)>0){
	$PAGE_VALUE["ba_url1"] = $bannerData1["ba_url"];
	$PAGE_VALUE["img1"] = "../pjpic/".$bannerData1["ba_image"];
}else{
	$PAGE_VALUE["ba_url1"] = "http://www.tiary.jp";
	$PAGE_VALUE["img1"] = "img/tiary01.png";
}

if(count($bannerData2)>0){
	$PAGE_VALUE["ba_url2"] = $bannerData2["ba_url"];
	$PAGE_VALUE["img2"] = "../pjpic/".$bannerData2["ba_image"];
}else{
	$PAGE_VALUE["ba_url2"] = "http://www.tiary.jp/shop_info.php";
	$PAGE_VALUE["img2"] = "img/tiary02.png";
}

if(count($bannerData3)>0){
	$PAGE_VALUE["ba_url3"] = $bannerData3["ba_url"];
	$PAGE_VALUE["img3"] = "../pjpic/".$bannerData3["ba_image"];
}else{
	$PAGE_VALUE["ba_url3"] = "http://direct.tiary.jp";
	$PAGE_VALUE["img3"] = "img/tiary03.jpg";
}


if($_POST["save_flag"]!=""){
	if($_POST["ba_title"] ==""){
		$PAGE_VALUE["ba_title_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($_POST["ba_url"]==""){
		$PAGE_VALUE["ba_url_err"] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if(strtotime($_POST["ba_start_y"]."-".$_POST["ba_start_m"]."-".$_POST["ba_start_d"])>strtotime($_POST["ba_end_y"]."-".$_POST["ba_end_m"]."-".$_POST["ba_end_d"])){
		$PAGE_VALUE["time_err"] = '<br/><p class="red">※必須項目です。正しくご入力ください。</p>';
		$error_flag = 1;
	}

	if(checkdate($_POST["ba_start_m"],$_POST["ba_start_d"],$_POST["ba_start_y"])==false){
		$PAGE_VALUE["time_err"] = '<br/><p class="red">※必須項目です。正しくご入力ください。</p>';
		$error_flag = 1;
	}else{
		$ba_start = $_POST["ba_start_y"]."-".$_POST["ba_start_m"]."-".$_POST["ba_start_d"];
	}

	if(checkdate($_POST["ba_end_m"],$_POST["ba_end_d"],$_POST["ba_end_y"])==false){
		$PAGE_VALUE["time_err"] = '<br/><p class="red">※必須項目です。正しくご入力ください。</p>';
		$error_flag = 1;
	}else{
		$ba_end = $_POST["ba_end_y"]."-".$_POST["ba_end_m"]."-".$_POST["ba_end_d"];
	}

	if($_POST["part_flag"]=="3"){
		if($_FILES['bannerfile']['tmp_name'] != ''){
			$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
			$basename = basename($_FILES['bannerfile']['tmp_name']);
			$fileext = strrchr($_FILES['bannerfile']['name'], '.');
			$filename = $basename . $fileext;
			$uploadfile = $uploaddir . "/" . $filename;
			$is_uploaded = move_uploaded_file($_FILES['bannerfile']['tmp_name'], $uploadfile);
		}elseif($filename==""){
			$PAGE_VALUE["banner_img_err"] ='<br />※必須項目です。正しくご入力ください。';
			$error_flag = 1;
		}
	}

	if($_POST["part_flag"]=="4"){
		if($_FILES['bannerfile2']['tmp_name'] != ''){
			$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
			$basename = basename($_FILES['bannerfile2']['tmp_name']);
			$fileext = strrchr($_FILES['bannerfile2']['name'], '.');
			$filename = $basename . $fileext;
			$uploadfile = $uploaddir . "/" . $filename;
			$is_uploaded = move_uploaded_file($_FILES['bannerfile2']['tmp_name'], $uploadfile);
		}elseif($filename==""){
			$PAGE_VALUE["banner_img_err2"] ='<br />※必須項目です。正しくご入力ください。';
			$error_flag = 1;
		}
	}

	if($_POST["part_flag"]=="6"){
		if($_FILES['bannerfile3']['tmp_name'] != ''){
			$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
			$basename = basename($_FILES['bannerfile3']['tmp_name']);
			$fileext = strrchr($_FILES['bannerfile3']['name'], '.');
			$filename = $basename . $fileext;
			$uploadfile = $uploaddir . "/" . $filename;
			$is_uploaded = move_uploaded_file($_FILES['bannerfile3']['tmp_name'], $uploadfile);
		}elseif($filename==""){
			$PAGE_VALUE["banner_img_err3"] ='<br />※必須項目です。正しくご入力ください。';
			$error_flag = 1;
		}
	}


	if($error_flag!=1){
		unset($_DATA);
		$_DATA = array();
		$_DATA['banner_advertising']['ba_title'] = $_POST["ba_title"];
		$_DATA['banner_advertising']['ba_image'] = $filename;
		$_DATA['banner_advertising']['ba_url'] = $_POST["ba_url"];
		$_DATA['banner_advertising']['part_flag'] = $_POST["part_flag"];
		$_DATA['banner_advertising']['ba_start'] = $ba_start;
		$_DATA['banner_advertising']['ba_end'] = $ba_end;
		$_DATA['banner_advertising']['part_flag'] = $_POST["part_flag"];
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