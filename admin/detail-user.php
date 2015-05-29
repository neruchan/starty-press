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
$ins_ipfDB1->ini("model_tiary");
$ins_ipfDB1->ini("users");
/***********************
 * 画面表示処理
***********************/
$template_file = "detail-user.template";
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

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_GET["uid"]==""){
	header('Location: user.php');
}

$userData = $model_tiary_admin->selectUserDataByID($_GET["uid"]);
if(count($userData)>0){
	$PAGE_VALUE["id"] = $userData["id"];//mb_substr($userData["sc_title"],0,20,"UTF-8");
	$PAGE_VALUE["email"] = $userData["email"];
	$PAGE_VALUE["nickname"] = ($userData["nickname"]!=""?$userData["nickname"]:"なし");
	$PAGE_VALUE["birthday"] = date("Y/m/d",strtotime($userData["birthday"]));
	$PAGE_VALUE["addtime"] = date("Y/m/d",strtotime($userData["created"]));
	$PAGE_VALUE["fullname"] = ($userData["fullname"]!=""?$userData["fullname"]:"なし");
	$PAGE_VALUE["fullname_kana"] = ($userData["fullname_kana"]!=""?$userData["fullname_kana"]:"なし");
	$PAGE_VALUE["zipcode"] = ($userData["zipcode"]!=""?$userData["zipcode"]:"なし");
	$PAGE_VALUE["todoufuken"] = ($userData["todoufuken"]!=""?$userData["todoufuken"]:"なし");
	$PAGE_VALUE["banti"] = ($userData["banti"]!=""?$userData["banti"]:"なし");
	$PAGE_VALUE["phonenumber"] = ($userData["phonenumber"]!=""?$userData["phonenumber"]:"なし");

	
	$entryNum = $model_tiary->selectRightEntryNum($_GET["uid"]);
	$PAGE_VALUE['entry_num'] = ($entryNum != ""? $entryNum: 0);
	
	$pvnum = "".$model_tiary->selectRightPvNum($_GET["uid"]);
	$PAGE_VALUE['pv_num'] = ($pvnum != ""? $pvnum: 0);
	
	
	$valuesForLoop['dataAll'] = $model_tiary->selectMyNewEntryAll($userData["id"]);
	
	foreach($valuesForLoop['dataAll'] as $key => $val) {
		$valuesForLoop['dataAll'][$key]["no"] = ($key+1)+($page*10);
		$valuesForLoop['dataAll'][$key]["id"] = $val["id"];//mb_substr($val["sc_title"],0,20,"UTF-8");

		if($val["categroy"]!="" && $val["categroy"]!="0"){
			$categroy = "";
			$categoryarr = explode(',', $val["categroy"]);
			for ($i = 0; $i < count($categoryarr); $i++) {
				$kigo = "";
				if($i!=0)
				$kigo = ",";
				$categroy .= $kigo.$article_category_user[$categoryarr[$i]];
			}
			$valuesForLoop['dataAll'][$key]["categroy"] = $categroy;
		}else{
			$valuesForLoop['dataAll'][$key]["categroy"] = "";
		}
		$valuesForLoop['dataAll'][$key]["title"] = $val["title"];
	
		$userData=$users->selectUserInfo($val["userid"]);
		$valuesForLoop['dataAll'][$key]["nickname"] = ($userData[0]["nickname"]!=""?$userData[0]["nickname"]:$userData[0]["username"]);
		$valuesForLoop['dataAll'][$key]["addtime"] = date("Y/m/d H:i",strtotime($val["addtime"]));
		$valuesForLoop['dataAll'][$key]["article_access_num"] = $val["access_num"];
	}
	
}else{
	header('Location: user.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>