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
$ins_ipfDB1->ini("model_tiary_admin");
$ins_ipfDB1->ini("users");
/***********************
 * 画面表示処理
***********************/


session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$PAGE_VALUE["isSet"] = '';

$settings = $model_tiary_admin->selectRSSSettings();

if(count($settings)>0){
	
	$isSet = $settings[0]['is_set'];
	
	if($isSet==1){
		$PAGE_VALUE["isSet"] = 'checked="checked"';
	}
	
	if($_POST['update_flag']){
		$_DATA = array();
		if($_FILES['csv_file']['tmp_name'] != ''){
			$tmp = $_FILES['csv_file']['tmp_name'];
			$name = $_FILES['csv_file']['name'];

			//Can be any full path, just don't end with a /. That will be added in in the path variable
			$uploads_dir = $settings[0]['path'];

			$path = $uploads_dir.'/'.$name;
			
			if(move_uploaded_file($tmp, $path)){
				$_DATA['rss_yahoo_settings']['filename'] = $name;
			}
		}
		
		$_DATA['rss_yahoo_settings']['is_set'] = ($_POST['isSet']!=""?1:0);
		
		$ins_ipfDB1->dataControl("update", "id = 1");
		header('Location: rss.php');
	}
	
}else{
	header('Location: main.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>