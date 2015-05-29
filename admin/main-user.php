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
$ins_ipfDB1->ini("users");
/***********************
 * 画面表示処理
***********************/
session_start();

if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$template_file = "main-user.template";
$valuesForLoop['dataAll'] = array();
$valuesForLoop['pages'] = array();
$PAGE_VALUE[str_prev_page] = "";
$PAGE_VALUE[str_next_page] = "";
$PAGE_VALUE['error_csv']="";
session_start();
//ページデータのセット
$page = $_REQUEST['p'];
if(!$page)
$page = 0;
$npage = 10;

//ユーザー削除
if($_POST["search_flag1"]=="del"){
	if($_POST["delete_id"]){
		$model_tiary_admin->deleteArticle(implode(',', $_POST["delete_id"]));
		header("Location: main-user.php");
	}
}


//カテゴリ検索
if($_POST["search_a_category"]!=""){
	$_SESSION["sess_a_category"] = $_POST["search_a_category"];
}

//投稿日付検索
if($_POST["search_a_addtime"]!=""){
	$_SESSION["sess_a_addtime"] = $_POST["search_a_addtime"];
}

//投稿日付検索
if($_POST["search_a_pv"]!=""){
	$_SESSION["sess_a_pv"] = $_POST["search_a_pv"];
}



$PAGE_VALUE["article_category_pulldown"] = setOptions($article_category_user,$_SESSION["sess_a_category"]);
$PAGE_VALUE["writer_pulldown"] = setOptions($writers,$_SESSION["sess_writer"]);
$PAGE_VALUE["article_addtime_pulldown"] = setOptions($addtime_sorts,$_SESSION["sess_a_addtime"]);

$PAGE_VALUE["article_pv_pulldown"] = setOptions($pv_sorts,$_SESSION["sess_a_pv"]);


//sessionリセット
unset($_SESSION["sess_a_num"]);
unset($_SESSION["sess_audition_time"]);
unset($_SESSION["search_shop_category"]);
unset($_SESSION["sess_shop_access"]);

if($_POST['csvFlag']){
	
	
	
	$number = ($_POST['noOfDataCSV']!=""?$_POST['noOfDataCSV']:$defaultCSV);
	
	if(is_numeric($number)){
		download_send_headers("article_user_data_export_" . date("Y-m-d") . ".csv");
		$valuesForLoop['dataAllForCSV'] = $model_tiary_admin->selectArticleAll("","","1",$number,0,true);
	
		$arrayForCSV = array();
		foreach($valuesForLoop['dataAllForCSV'] as $key => $val) {
			$arrayForCSV[$key]["no"] = ($key+1);
			$arrayForCSV[$key]["id"] = $val["id"];//mb_substr($val["sc_title"],0,20,"UTF-8");
			if($val["categroy"]!="" && $val["categroy"]!="0"){
				$categroy = "";
				$categoryarr = explode(',', $val["categroy"]);
				for ($i = 0; $i < count($categoryarr); $i++) {
					$kigo = "";
					if($i!=0)
					$kigo = ",";
					$categroy .= $kigo.$article_category_user[$categoryarr[$i]];
				}
				$arrayForCSV[$key]["category"] = $categroy;
			}else{
				$arrayForCSV[$key]["category"] = "";
			}
			$arrayForCSV[$key]["title"] = $val["title"];
            $arrayForCSV[$key]["content"] = strip_tags(mb_strimwidth($val['contents'],0,50,"…",utf8));
			$arrayForCSV[$key]["image"] = $val["image"];
			//$arrayForCSV[$key]["contents"] = $val["contents"];
			$arrayForCSV[$key]["source_name"] = $val["source_name"];
			$arrayForCSV[$key]["links"] = $val["links"];
			$arrayForCSV[$key]["access_num"] = $val["access_num"];
			$arrayForCSV[$key]["addtime"] = $val["addtime"];
			$userData=$users->selectUserInfo($val["userid"]);
			$arrayForCSV[$key]["userid"] = $val["userid"];
			$arrayForCSV[$key]["nickname"] = ($userData[0]["nickname"]!=""?$userData[0]["nickname"]:$userData[0]["username"]);
            if($val["tag"]){
                $tags = explode(",",$val["tag"]);
                $printsTags = "";   
                foreach ($tags as $val) {
                    $tagDetail = $model_tiary_admin->selectTagDetailById($val);
                    $printsTags .= $tagDetail['name'].",";
                }
                $arrayForCSV[$key]["tag"] = $printsTags;
            }
            else{
				$arrayForCSV[$key]["tag"] = "";
			}
		}
	
	
		echo array2csv($arrayForCSV);
		die();
	}
	else{
		$PAGE_VALUE['error_csv']="数字だけを入力下さい。";
	}
	
	
}

//ユーザー情報取得
$PAGE_VALUE["all_num"] = $model_tiary_admin->selectArticleAllNum(true);
$dataCnt = $model_tiary_admin->selectArticleCntAll($_SESSION["sess_a_category"],$_SESSION["sess_writer"],$_SESSION["sess_a_addtime"],true);
$PAGE_VALUE["search_num"] = $dataCnt;
$valuesForLoop['dataAll'] = $model_tiary_admin->selectArticleAll($_SESSION["sess_a_category"],$_SESSION["sess_writer"],$_SESSION["sess_a_addtime"],$npage,$page,true,"","",$_SESSION["sess_a_pv"]);
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
    
    
    $userid = $val["userid"];
    if($userid){
        $data = json_decode(file_get_contents('http://tiary.jp/app/member_detail.php?i='.$userid));
        $temp = $data->{'result'};
        $userData = get_object_vars($temp[0]);
        $valuesForLoop['dataAll'][$key]["nickname"] =($userData["nickname"]!=""?$userData["nickname"]:$userData["username"]);
        
    }
    else{
        $valuesForLoop['dataAll'][$key]["nickname"] ="";
    }
	
	$valuesForLoop['dataAll'][$key]["addtime"] = date("Y/m/d H:i",strtotime($val["addtime"]));
	$valuesForLoop['dataAll'][$key]["article_access_num"] = $val["access_num"];

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
							$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="main-user.php?p='.$i.'">';
							$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';
						}else{
							continue;
						}
					}elseif($i<10){
						$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="main-user.php?p='.$i.'">';
						$valuesForLoop['pages'][$i]['ipage_link_a'] = '</a>';

					}else{
						break;
					}
				}else{
					$valuesForLoop['pages'][$i]['ipage_link_str'] = '<a href="main-user.php?p='.$i.'">';
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

function array2csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}

function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();

?>