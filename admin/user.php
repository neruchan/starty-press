<?php
/*
* ファイル名 : main.php
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
$ins_ipfDB1->ini("model_tiary");
/***********************
 * 画面表示処理
***********************/
session_start();

if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$template_file = "user.template";
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
		$model_tiary_admin->deleteUser(implode(',', $_POST["delete_id"]));
		header("Location: user.php");
	}
}


//カテゴリ検索
if($_POST["pv_search"]!=""){
	$_SESSION["sess_pv_search"] = $_POST["pv_search"];
}

//ライター検索
if($_POST["search_article"]!=""){
	$_SESSION["sess_article"] = $_POST["search_article"];
}

//ID検索
if($_POST["search_userid"]!=""){
	$_SESSION["sess_userid"] = $_POST["search_userid"];
}
if($_SESSION["sess_userid"]!=""){
	$PAGE_VALUE["search_userid"] = $_SESSION["sess_userid"];
}
//ニックネーム検索
if($_POST["search_nickname"]!=""){
	$_SESSION["sess_nickname"] = $_POST["search_nickname"];
}
if($_SESSION["sess_nickname"]!=""){
	$PAGE_VALUE["search_nickname"] = $_SESSION["sess_nickname"];
}


$PAGE_VALUE["search_userid"] = $_SESSION["sess_userid"];
$PAGE_VALUE["search_nickname"] = $_SESSION["sess_nickname"];
$PAGE_VALUE["article_pv_pulldown"] = setOptions($user_pv_category,$_SESSION["sess_pv_search"]);
$PAGE_VALUE["article_pulldown"] = setOptions($user_article_category,$_SESSION["sess_article"]);


//sessionリセット
unset($_SESSION["sess_a_num"]);
unset($_SESSION["sess_audition_time"]);
unset($_SESSION["search_shop_category"]);
unset($_SESSION["sess_shop_access"]);

//ユーザー情報取得
$PAGE_VALUE["all_num"] = $model_tiary_admin->selectUserAllNum();
$dataCnt = $model_tiary_admin->selectUserCntAll($_SESSION["sess_userid"],$_SESSION["sess_nickname"],$_SESSION["sess_pv_search"]);
$PAGE_VALUE["search_num"] = $dataCnt;
$valuesForLoop['dataAll'] = $model_tiary_admin->selectUserAll($_SESSION["sess_userid"],$_SESSION["sess_nickname"],$_SESSION["sess_pv_search"],$_SESSION["sess_article"],$npage,$page);
foreach($valuesForLoop['dataAll'] as $key => $val) {
	$valuesForLoop['dataAll'][$key]["no"] = ($key+1)+($page*10);
	$valuesForLoop['dataAll'][$key]["id"] = $val["id"];//mb_substr($val["sc_title"],0,20,"UTF-8");
	$valuesForLoop['dataAll'][$key]["nickname"] = ($val["nickname"]!=""?$val["nickname"]:$val["username"]);
	$valuesForLoop['dataAll'][$key]["birthday"] = date("Y/m/d",strtotime($val["birthday"]));
	$valuesForLoop['dataAll'][$key]["addtime"] = date("Y/m/d",strtotime($val["created"]));;

	$valuesForLoop['dataAll'][$key]['entry_num'] = ($val['num_article'] != ""? $val['num_article']: 0);
	
	$valuesForLoop['dataAll'][$key]['pv_num'] = ($val['num_pv'] != ""? $val['num_pv']: 0);

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
							$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="user.php?p='.$i.'">';
							$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';
						}else{
							continue;
						}
					}elseif($i<10){
						$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="user.php?p='.$i.'">';
						$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';

					}else{
						break;
					}
				}else{
					$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="user.php?p='.$i.'">';
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