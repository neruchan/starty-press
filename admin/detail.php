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
$PAGE_VALUE["video_part"] = '';
$PAGE_VALUE["tag"] = "";
session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

if($_GET["no"]=="" || $_GET["aid"]==""){
	header('Location: main.php');
}

$articleData = $model_tiary_admin->selectArticleByID($_GET["aid"]);
if(count($articleData)>0){
	if($articleData['is_outsource'] == 1){
		$template_file = "detail-out.template";
	}
	else{
		$template_file = "detail.template";
	}
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["aid"] =$_GET["aid"];
	$PAGE_VALUE["title"] = $articleData["title"];
	
	$PAGE_VALUE["contents"] = nl2br($articleData["contents"]);
	$PAGE_VALUE["source_name"] = $articleData["source_name"];
	$PAGE_VALUE["links"] = $articleData["links"];
	$PAGE_VALUE["addtime"] = date('Y/m/d H:s',strtotime($articleData["addtime"]));
	$PAGE_VALUE["article_access_num"] = $articleData["access_num"];
	$PAGE_VALUE["entry_name"] = $articleData["entry_name"];
	
	$listTags = $model_tiary_admin->selectTagsByArticleId($_GET["aid"]);
	if($listTags){
		$printsTags  ="";
		foreach($listTags as $key => $val) {
			$comma = "";
			if($key != 0){
				$comma = ",";
			}
			$printsTags .= $comma.$val['name'];
		}
		$PAGE_VALUE["tag"] = $printsTags;
	}
    
    // if($articleData["tag"]){
// 			$tags = explode(",",$articleData["tag"]);
// 			foreach ($tags as $val) {
// 				$tagDetail = $model_tiary_admin->selectTagDetailById($val);
// 				$printsTags .= $tagDetail['name'].",";
// 			}
// 			$PAGE_VALUE["tag"] = $printsTags;
// 		}
    
	$PAGE_VALUE["edit_btn"] = '<a href="edit.php?aid='.$_GET["aid"].'&no='.$_GET["no"].'"><input type="button" class="space02" value="編集" /></a>';
	
	if($articleData["video_link"]){
		
		if(strpos($articleData["video_link"],"v=")!=false){
			$mv = substr($articleData["video_link"],(strpos($articleData["video_link"],"v=")+2),11);
		}
		if(strpos($articleData["video_link"],"be/")!=false){
			$mv = substr($articleData["video_link"],(strpos($articleData["video_link"],"be/")+3),11);
		}
		$iframe = '
		  <iframe width="320" height="220" src="//www.youtube.com/embed/'.$mv.'" frameborder="0" allowfullscreen></iframe>';
		
		$PAGE_VALUE["video_part"] = '
<tr>
<td class="title-tbl02">ビデオ</td>
<td class="pic">'.$iframe.'</td>
</tr>';
	}
    
    $userid = $articleData["userid"];
	
	if($articleData["userid"]){
        $data = json_decode(file_get_contents('http://tiary.jp/app/member_detail.php?i='.$userid));
        $temp = $data->{'result'};
        $userData = get_object_vars($temp[0]);
        $nickname =($userData["nickname"]!=""?$userData["nickname"]:$userData["username"]);
        
		$PAGE_VALUE["nickname_field"] = '
<tr>
<td class="title-tbl02">ユーザー名</td>
<td>'.$nickname.'</td>
</tr>';
		$catestr = "";
		if($articleData["categroy"]!=""){
			$catearr = explode(',', $articleData["categroy"]);
			foreach ($catearr as $key=>$val) {
				$kigou ="";
				if($key!=0)
				$kigou = ",";
				$catestr .= $kigou.$article_category_user[$val];
			}
		}
		$PAGE_VALUE["categroy"] = $catestr;
		$PAGE_VALUE["edit_btn"] = "";
        
        if(!$articleData['image']){
            $temp = $model_tiary_admin->selectTopBlockByArticleId($_GET["aid"]);
            $PAGE_VALUE["image"] = $temp['picture'];
        }
        else{
            $PAGE_VALUE["image"] = $articleData["image"];
        }
        
	}
	else{
        $PAGE_VALUE["image"] = $articleData["image"];
		$catestr = "";
		if($articleData["categroy"]!=""){
			$catearr = explode(',', $articleData["categroy"]);
			foreach ($catearr as $key=>$val) {
				$kigou ="";
				if($key!=0)
				$kigou = ",";
				$catestr .= $kigou.$new_article_categorys[$val];
			}
		}
		$PAGE_VALUE["categroy"] = $catestr;
	}
	
	
	$PAGE_VALUE["client_num"] = $model_tiary_admin->selectClientClickNum($_GET["aid"]);
	$PAGE_VALUE["pay_flag"] = ($articleData["pay_flag"]==1?"はい":"いいえ");
	if($articleData["client_url"]!=""){
		$PAGE_VALUE["client"] = "http://model.tiary.jp/ad.php?ad=".$_GET["aid"];
	}
	
	$PAGE_VALUE["writer_name"] =($articleData["name"]!=""?$articleData["name"]:"ライターなし");
}else{
	header('Location: main.php');
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>