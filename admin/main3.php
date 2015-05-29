<?php
/*
* ファイル名 : main3.php
* 機能名   : 記事管理一覧ページ
* 作成者   : tou
* 作成日   : 2013/08/08
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
session_start();

if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$template_file = "main3.template";
$valuesForLoop['dataAll'] = array();
$valuesForLoop['pages'] = array();
$PAGE_VALUE[str_prev_page] = "";
$PAGE_VALUE[str_next_page] = "";
session_start();
//ページデータのセット
$page = $_REQUEST['p'];
if(!$page)
$page = 0;
$npage = 10;

//ユーザー削除
if($_POST["search_flag1"]=="del"){
	if($_POST["delete_id"]){
		$model_tiary_admin->deleteAudition(implode(',', $_POST["delete_id"]));
		header("Location: main3.php");
	}
}


//投稿記事数検索
if($_POST["search_audition_time"]!=""){
	$_SESSION["sess_audition_time"] = $_POST["search_audition_time"];
}


$PAGE_VALUE["audition_time_pulldown"] = setOptions($addtime_sorts,$_SESSION["sess_audition_time"]);


//sessionリセット
unset($_SESSION["sess_a_category"]);
unset($_SESSION["sess_writer"]);
unset($_SESSION["sess_a_addtime"]);
unset($_SESSION["sess_a_num"]);
unset($_SESSION["sess_shop_categroy"]);
unset($_SESSION["sess_shop_access"]);
unset($_SESSION["sess_userid"]);
unset($_SESSION["sess_nickname"]);

//ユーザー情報取得
$PAGE_VALUE["all_num"] = $model_tiary_admin->selectAuditionAllNum();
$dataCnt = $model_tiary_admin->selectAuditionCntAll($_SESSION["sess_audition_time"]);
$PAGE_VALUE["search_num"] = $dataCnt;
$valuesForLoop['dataAll'] = $model_tiary_admin->selectAuditionAll($_SESSION["sess_audition_time"],$npage,$page);
foreach($valuesForLoop['dataAll'] as $key => $val) {
	$valuesForLoop['dataAll'][$key]["no"] = ($key+1)+($page*10);
	$valuesForLoop['dataAll'][$key]["id"] = $val["id"];//mb_substr($val["sc_title"],0,20,"UTF-8");
	$valuesForLoop['dataAll'][$key]["audition_title"] = $val["audition_title"];
	$valuesForLoop['dataAll'][$key]["audition_url"] = $val["audition_url"];
	$valuesForLoop['dataAll'][$key]["addtime"] = date('Y-m-d H:s',strtotime($val["addtime"]));
	$valuesForLoop['dataAll'][$key]["end_time"] = $val["end_time"];

	$pageCnt = intval($dataCnt / $npage);
	if($dataCnt > $pageCnt * $npage)
	$pageCnt++;
	//ページング
	if($dataCnt > $npage * ($page + 1)) {
		$PAGE_VALUE[str_next_page] = "次へ &raquo;";
		$PAGE_VALUE[next_page] = $page + 1;
	}

	if($pageCnt > 1) {
		for($i = 0; $i < $pageCnt; $i++) {

			if($i == $page) {
				$valuesForLoop['pages'][$i]['ipage_link_str'] = "";
				$valuesForLoop['pages'][$i]['ipage_link_a'] = "";
			}else {
				if($pageCnt>10){
					if($page>5){
						if(($page-$i)<6 && ($i-$page)<5){
							$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="main3.php?p='.$i.'">';
							$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';
						}else{
							continue;
						}
					}elseif($i<10){
						$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="main3.php?p='.$i.'">';
						$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';

					}else{
						break;
					}
				}else{
					$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="main3.php?p='.$i.'">';
					$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';
				}
			}
			$valuesForLoop['pages'][$i]['ipage'] = $i+1;
		}
	}

	if($page > 0) {
		$PAGE_VALUE[str_prev_page] = "&laquo; 前へ";
		$PAGE_VALUE[prev_page] = $page - 1;
	}
}



//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();

?>