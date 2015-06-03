<?php
/*
* ファイル名 : pickup.php
* 機能名   : ピックアップ一覧ページ
* 作成者   : NELSON
* 作成日   : 2015/6/01
*/

/***********************
 * 定義
***********************/
require_once "tiary/ipfTemplate.php";
require_once "startypress/ipfDB1.php";
/***********************
 * コンストラクタ
***********************/
$ins_ipfTemplate = new ipfTemplate();
$ins_ipfDB1 = new ipfDB1;
$ins_ipfDB1->ini("starty_press");
/***********************
 * 画面表示処理
 ***********************/
//共通処理
session_start();
$template_file = "business.template";

require_once "define.php";

$valuesForLoop['pages'] = array();
$PAGE_VALUE[str_prev_page] = "";
$PAGE_VALUE[str_next_page] = "";

//ページデータのセット
$page = $_REQUEST['p'];
if(!$page)
$page = 0;
$npage = 24;

$dataCnt = $starty_press->selectArticleCategroyCnt("","2");
$valuesForLoop['article_all'] = $starty_press->selectArticleCategroyAll("","2",$npage,$page);
foreach ($valuesForLoop['article_all'] as $key =>$val) {
	$valuesForLoop['article_all'][$key]['article_id'] = $val['id'];
	$valuesForLoop['article_all'][$key]['article_title'] = $val['title'];
	$categoryarr = explode(',', $val["categroy"]);
    $valuesForLoop['article_all'][$key]['article_category'] = $article_categroys[$categoryarr[0]];
    $valuesForLoop['article_all'][$key]['article_contents'] = mb_strimwidth(strip_tags($val['contents']), 0, 120,'…',utf8);
	$valuesForLoop['article_all'][$key]['article_image'] = $val['image'];
	$valuesForLoop['article_all'][$key]['article_addtime'] = date('Y.m.d',strtotime($val['addtime']));
	
	$pageCnt = intval($dataCnt / $npage);
	if($dataCnt > $pageCnt * $npage)
	$pageCnt++;
	//ページング
	if($dataCnt > $npage * ($page + 1)) {
		$PAGE_VALUE[str_next_page] = '<li><a href="business.php?p='.($page + 1).'">&rsaquo;</a></li>';
		$PAGE_VALUE[next_page] = $page + 1;
	}
	if($pageCnt > 1) {
		for($i = 0; $i < $pageCnt; $i++) {

			if($i == $page) {
				$valuesForLoop['pages'][$i]['ipage_link_str'] = '<div>';
				$valuesForLoop['pages'][$i]['ipage_link_a'] = '</div>';
			}else {
				if($pageCnt>10){
					if($page>5){
						if(($page-$i)<6 && ($i-$page)<5){
							$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="business.php?p='.$i.'">';
							$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';
						}else{
							continue;
						}
					}elseif($i<10){
						$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="business.php?p='.$i.'">';
						$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';

					}else{
						break;
					}
				}else{
					$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="business.php?p='.$i.'">';
					$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';
				}
			}
			$valuesForLoop['pages'][$i]['ipage'] = $i+1;
		}
	}else{
		$PAGE_VALUE["page_tab1"] = "<!--";
		$PAGE_VALUE["page_tab2"] = "-->";
	}
	if($page > 0) {
		$PAGE_VALUE[str_prev_page] = '<li><a href="business.php?p='.($page - 1).'">&lsaquo;</a></li>';
	}
}



//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();


?>