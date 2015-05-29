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

$template_file = "detail4.template";
$PAGE_VALUE["ba_title"]="";
$PAGE_VALUE["ba_url"]="";
$PAGE_VALUE["time_err"]="";


if($_GET["bid"]!=""){
	if($_POST["save_flag"]!=""){


		if(strtotime($_POST["ba_start_y"]."-".$_POST["ba_start_m"]."-".$_POST["ba_start_d"])>strtotime($_POST["ba_end_y"]."-".$_POST["ba_end_m"]."-".$_POST["ba_end_d"])){
			$PAGE_VALUE["time_err"] = '<br/><p class="red">※必須項目です。正しくご入力ください。</p>';
			$error_flag = 1;
		}

		if(checkdate($_POST["ba_start_m"],$_POST["ba_start_d"],$_POST["ba_start_y"])==false){
			$PAGE_VALUE["time_err"] = '<br/><p class="red">※必須項目です。正しくご入力ください。</p>';
			$error_flag = 1;
		}else{
			$start_time = $_POST["ba_start_y"]."-".$_POST["ba_start_m"]."-".$_POST["ba_start_d"];
		}

		if(checkdate($_POST["ba_end_m"],$_POST["ba_end_d"],$_POST["ba_end_y"])==false){
			$PAGE_VALUE["time_err"] = '<br/><p class="red">※必須項目です。正しくご入力ください。</p>';
			$error_flag = 1;
		}else{
			$end_time = $_POST["ba_end_y"]."-".$_POST["ba_end_m"]."-".$_POST["ba_end_d"];
		}
	}
	$bannerData = $banner_admin->selectBannerByID($_GET["bid"],$start_time,$end_time);

	$PAGE_VALUE["start_year_pulldown"] = setOptions($open_years,$_POST["ba_start_y"]);

	$PAGE_VALUE["start_month_pulldown"] = setOptions($open_months,$_POST["ba_start_m"]);

	$PAGE_VALUE["start_day_pulldown"] = setOptions($open_days,$_POST["ba_start_d"]);

	$PAGE_VALUE["end_year_pulldown"] = setOptions($open_years,$_POST["ba_end_y"]);

	$PAGE_VALUE["end_month_pulldown"] = setOptions($open_months,$_POST["ba_end_m"]);

	$PAGE_VALUE["end_day_pulldown"] = setOptions($open_days,$_POST["ba_end_d"]);

	$PAGE_VALUE["ba_title"]=$bannerData["ba_title"];
	$PAGE_VALUE["ba_url"]=$bannerData["ba_url"];
	$PAGE_VALUE["ba_image"]="../pjpic/".$bannerData["ba_image"];
	$PAGE_VALUE["part_flag"]=$part_flags[$bannerData["part_flag"]];
	$PAGE_VALUE["start_time"]=date('Y年m月d日',strtotime($bannerData["ba_start"]));
	$PAGE_VALUE["end_time"]=date('Y年m月d日',strtotime($bannerData["ba_end"]));
	$PAGE_VALUE["click_num"]=$bannerData["click_num"];
	$PAGE_VALUE["id"]=$bannerData["id"];
}else{
	header('Location: banner.php');
}


//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>