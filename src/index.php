<?php
/*
* ファイル名 : index.php
* 機能名   : トップページ
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
$template_file = "index.template";

require_once "define.php";

$valuesForLoop['article_banner'] = $starty_press->selectArticleCategroyAll("","",5,0);
foreach ($valuesForLoop['article_banner'] as $key =>$val) {
	$valuesForLoop['article_banner'][$key]['article_id'] = $val['id'];
	$valuesForLoop['article_banner'][$key]['article_title'] = $val['title'];
	$valuesForLoop['article_banner'][$key]['article_image'] = $val['image'];
}


$valuesForLoop['article_all'] = $starty_press->selectArticleCategroyAll("","",5,0);
foreach ($valuesForLoop['article_all'] as $key =>$val) {
	$valuesForLoop['article_all'][$key]['article_id'] = $val['id'];
	$valuesForLoop['article_all'][$key]['article_title'] = $val['title'];
	$categoryarr = explode(',', $val["categroy"]);
    $valuesForLoop['article_all'][$key]['article_category'] = $article_categroys[$categoryarr[0]];
    $valuesForLoop['article_all'][$key]['article_contents'] = mb_strimwidth($val['contents'], 0, 120,'…',utf8);
	$valuesForLoop['article_all'][$key]['article_image'] = $val['image'];
	$valuesForLoop['article_all'][$key]['article_addtime'] = date('Y.m.d',strtotime($val['addtime']));
}


//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();


?>