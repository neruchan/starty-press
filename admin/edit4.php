<?php
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
session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$template_file = "edit4.template";
$PAGE_VALUE["ba_title"]=$_POST["ba_title"];
$PAGE_VALUE["ba_url"]=$_POST["ba_url"];
$PAGE_VALUE["time_err"]="";
$PAGE_VALUE["banner_img_err"]="";
$PAGE_VALUE["ba_url_err"]="";
$PAGE_VALUE["ba_title_err"]="";


if($_GET["bid"]!=""){
	$bannerData = $banner_admin->selectBannerByID($_GET["bid"]);
	$time_start_arr = explode('-', $bannerData["ba_start"]);
	$PAGE_VALUE["start_year_pulldown"] = setOptions($open_years,$time_start_arr[0]);

	$PAGE_VALUE["start_month_pulldown"] = setOptions($open_months,$time_start_arr[1]);

	$PAGE_VALUE["start_day_pulldown"] = setOptions($open_days,$time_start_arr[2]);

	$time_end_arr = explode('-', $bannerData["ba_end"]);
	$PAGE_VALUE["end_year_pulldown"] = setOptions($open_years,$time_end_arr[0]);

	$PAGE_VALUE["end_month_pulldown"] = setOptions($open_months,$time_end_arr[1]);

	$PAGE_VALUE["end_day_pulldown"] = setOptions($open_days,$time_end_arr[2]);

	$PAGE_VALUE["ba_title"]=$bannerData["ba_title"];
	$PAGE_VALUE["ba_url"]=$bannerData["ba_url"];

	$PAGE_VALUE["ba_image"]="../pjpic/".$bannerData["ba_image"];
	$PAGE_VALUE["part_flag"]=$part_flag[$bannerData["part_flag"]];

	$PAGE_VALUE["click_num"]=$bannerData["click_num"];
	$PAGE_VALUE["id"]=$bannerData["id"];
	if($_POST["save_flag"]!=""){

		$PAGE_VALUE["start_year_pulldown"] = setOptions($open_years,$_POST["ba_start_y"]);

		$PAGE_VALUE["start_month_pulldown"] = setOptions($open_months,$_POST["ba_start_m"]);

		$PAGE_VALUE["start_day_pulldown"] = setOptions($open_days,$_POST["ba_start_d"]);

		$PAGE_VALUE["end_year_pulldown"] = setOptions($open_years,$_POST["ba_end_y"]);

		$PAGE_VALUE["end_month_pulldown"] = setOptions($open_months,$_POST["ba_end_m"]);

		$PAGE_VALUE["end_day_pulldown"] = setOptions($open_days,$_POST["ba_end_d"]);

		$PAGE_VALUE["part_flag_pulldown"] = setOptions($part_flags,$_POST["part_flag"]);

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

		if($_FILES['bannerfile']['tmp_name'] != ''){
			$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
			$basename = basename($_FILES['bannerfile']['tmp_name']);
			$fileext = strrchr($_FILES['bannerfile']['name'], '.');
			$filename = $basename . $fileext;
			$uploadfile = $uploaddir . "/" . $filename;
			$is_uploaded = move_uploaded_file($_FILES['bannerfile']['tmp_name'], $uploadfile);
		}

		if($error_flag!=1){
			unset($_DATA);
			$_DATA = array();
			$_DATA['banner_advertising']['ba_title'] = $_POST["ba_title"];
			if($_FILES['bannerfile']['tmp_name']!=""){
				$_DATA['banner_advertising']['ba_image'] = $filename;
			}
			$_DATA['banner_advertising']['ba_url'] = $_POST["ba_url"];
			$_DATA['banner_advertising']['part_flag'] = $_POST["part_flag"];
			$_DATA['banner_advertising']['ba_start'] = $ba_start;
			$_DATA['banner_advertising']['ba_end'] = $ba_end;
			$ins_ipfDB1->dataControl("update", "id = ".$_GET["bid"]);
			unset($_DATA);
			header('Location: banner.php');
		}else{
			$PAGE_VALUE["ba_title"]=$_POST["ba_title"];
			$PAGE_VALUE["ba_url"]=$_POST["ba_url"];
		}
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