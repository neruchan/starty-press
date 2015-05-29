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
$ins_ipfDB1->ini("banner_admin");
$ins_ipfDB1->ini("model_tiary_admin");
session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}
$template_file = "banner.template";
$valuesForLoop['dataAll'] = array();
$valuesForLoop['pages'] = array();
$PAGE_VALUE[str_prev_page] = "";
$PAGE_VALUE[str_next_page] = "";
$PAGE_VALUE["search_banner"] = "";


//削除
if($_POST["del_flag"]!=""){
	if($_POST["delete_id"]){
		$banner_admin->deleteBanner(implode(',', $_POST["delete_id"]));
		header("Location: banner.php");
	}
}

if($_POST["search_flag"]!=""){
	if($_POST["search_banner"]!=""){
		$_SESSION["sess_banner"] = $_POST["search_banner"];
	}else{
		unset($_SESSION["sess_banner"]);
	}
}
$PAGE_VALUE["search_banner"] = $_SESSION["sess_banner"];

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

$page = $_REQUEST['p'];
if(!$page)
$page = 0;
$npage = 6;

$dataCnt = $banner_admin->selectBannerCnt($_SESSION["sess_banner"]);
$valuesForLoop['dataAll'] = $banner_admin->selectBannerAll($_SESSION["sess_banner"],$npage,$page);

$PAGE_VALUE["open_banner_num"] = $banner_admin->openBannerNum();

//全広告数
$PAGE_VALUE["allNum"] = $dataCnt;

$pageCnt = intval($dataCnt / $npage);
if($dataCnt > $pageCnt * $npage)
$pageCnt++;
foreach($valuesForLoop['dataAll'] as $key => $val) {
	$valuesForLoop['dataAll'][$key]["no"] = ($key+1)+($page*6);
	$valuesForLoop['dataAll'][$key]["id"] = $val["id"];//mb_substr($val["sc_title"],0,20,"UTF-8");
	$valuesForLoop['dataAll'][$key]["ba_url"] = $val["ba_url"];
	$valuesForLoop['dataAll'][$key]["ba_image"] = "../pjpic/".$val["ba_image"];
	$valuesForLoop['dataAll'][$key]["ba_title"] = $val["ba_title"];
	$valuesForLoop['dataAll'][$key]["click_num"] = $val["click_num"];
	$valuesForLoop['dataAll'][$key]["ba_start"] = date('Y年m月d日',strtotime($val["ba_start"]));
	$valuesForLoop['dataAll'][$key]["ba_end"] = date('Y年m月d日',strtotime($val["ba_end"]));

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
							$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="banner.php?p='.$i.$tg.'">';
							$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';
						}else{
							continue;
						}
					}elseif($i<10){
						$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="banner.php?p='.$i.$tg.'">';
						$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';

					}else{
						break;
					}
				}else{
					$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="banner.php?p='.$i.$tg.'">';
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