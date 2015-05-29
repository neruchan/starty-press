<?php
/*
 * ファイル名 : edit.php
 * 機能名     : 記事編集ページ
 * 作成者     : トウ
 * 作成日     : 13/08/09
 */

/***********************
* 定義
***********************/
require_once "tiary/ipfTemplate.php";
require_once "startypress/ipfDB1.php";
require_once "define_admin.php";
require_once 'src/facebook.php';
/***********************
 * コンストラクタ
***********************/
$ins_ipfTemplate = new ipfTemplate();
$ins_ipfDB1 = new ipfDB1;
$ins_ipfDB1->ini("model_tiary_admin");
/***********************
 * 画面表示処理
***********************/
$PAGE_VALUE["tag"] = "";
$PAGE_VALUE["title"] = "";
$PAGE_VALUE["up_img"] = "";
$PAGE_VALUE["contents"] = "";
$PAGE_VALUE["links"] = "";
$PAGE_VALUE["source_name"] = "";
$PAGE_VALUE["addtime"] = "";
$PAGE_VALUE["aid"] = "";
$PAGE_VALUE["no"] = "";
$PAGE_VALUE["entry_name"] = "";
$PAGE_VALUE["client_url"] = "";
$PAGE_VALUE["client"] = "";
$PAGE_VALUE[article_img_err] = "";
$PAGE_VALUE[title_err] = "";
$PAGE_VALUE[category_err] = "";
$PAGE_VALUE[contents_err] = "";
$PAGE_VALUE[writer_id_err] = "";
$PAGE_VALUE["pay_flag_checked"] = '';
$PAGE_VALUE["postToFbChecked"] = '';
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
		$template_file = "edit-out.template";
	}
	else{
		$template_file = "edit.template";
	}
	
	$PAGE_VALUE["kiji_category_pulldown"] = setOptions($kiji_type_edit,$articleData['is_outsource']);
	
	$listTags = $model_tiary_admin->selectTagsByArticleId($_GET["aid"]);
	if($listTags){
		$printsTags  ="";
		foreach($listTags as $key => $val) {
			$comma = "";
			if($key != 0){
				$comma = " ";
			}
			$printsTags .= $comma.$val['name'];
		}
		$PAGE_VALUE["tag"] = $printsTags;
	}
     // if($articleData["tag"]){
// 			$tags = explode(",",$articleData["tag"]);
// 			foreach ($tags as $val) {
// 				$tagDetail = $model_tiary_admin->selectTagDetailById($val);
// 				$printsTags .= $tagDetail['name']." ";
// 			}
// 			$PAGE_VALUE["tag"] = $printsTags;
// 		}
	$PAGE_VALUE["writer_pulldown"] = "";
	$writeData = $model_tiary_admin->selectWriterData();
	if(count($writeData)>0){
		foreach ($writeData as $val) {
			$writearr[$val["id"]] = $val["name"];
		}
		$PAGE_VALUE["writer_pulldown"] = setOptions($writearr,$articleData["writer_id"]);
	}
	$PAGE_VALUE["category_checkbox"] = setCheckboxArticle($new_article_categorys,$articleData["categroy"]);
	$PAGE_VALUE["no"] = $_GET["no"];
	$PAGE_VALUE["aid"] =$_GET["aid"];
    $PAGE_VALUE["pv"] = $articleData["access_num"];
	$PAGE_VALUE["title"] = $articleData["title"];
	$PAGE_VALUE["image"] = $articleData["image"];
	$PAGE_VALUE["contents"] = $articleData["contents"];
	$PAGE_VALUE["entry_name"] = $articleData["entry_name"];
	$PAGE_VALUE["client_url"] = $articleData["client_url"];
	if($articleData["pay_flag"]==1){
		$PAGE_VALUE["pay_flag_checked"] = 'checked="checked"';
	}
	if($articleData["client_url"]!=""){
		$PAGE_VALUE["client"] = "http://model.tiary.jp/ad.php?ad=".$_GET["aid"];
	}
	$PAGE_VALUE["links"] = $articleData["links"];
	$PAGE_VALUE["source_name"] = $articleData["source_name"];
	$PAGE_VALUE["addtime"] = date('Y/m/d H:s',strtotime($articleData["addtime"]));
}else{
	header('Location: main.php');
}

if($_POST["update_flag"]!=""){
	if($_FILES['article_img']['tmp_name'] != ''){
		$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
		$basename = basename($_FILES['article_img']['tmp_name']);
		$fileext = strrchr($_FILES['article_img']['name'], '.');
		$filename = $basename . $fileext;
		$uploadfile = $uploaddir . "/" . $filename;
		$is_uploaded = move_uploaded_file($_FILES['article_img']['tmp_name'], $uploadfile);
		$_POST["up_img"] = "http://model.tiary.jp/pjpic/".$filename;
	}

	$error_flag = 0;
	if($_POST["title"] ==""){
		$PAGE_VALUE[title_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if(!$_POST["category"]){
		$PAGE_VALUE[category_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($_POST["contents"] ==""){
		$PAGE_VALUE[contents_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	if($error_flag !=1){
        
        
      	$model_tiary_admin->deleteAllTagByArticleId($_GET["aid"]);
		mb_regex_encoding('UTF-8');
      	mb_internal_encoding("UTF-8"); 
      $tagArray = mb_split('[[:space:]]', $_POST['tag']);
// 		$tagArray = explode(" ", $_POST['tag']);
		for($i = 0 ; $i < count($tagArray); $i++){
			if($tagArray[$i] != "" && is_string($tagArray[$i])){
				$id = $model_tiary_admin->selectTagExists($tagArray[$i]);
				if(!$id){
					unset($_DATA);
	 				$_DATA = array();
					$_DATA['article_tag']['name'] = $tagArray[$i];
					$_DATA['article_tag']['delete_flag'] = 0;
					$_DATA['article_tag']['add_date'] = date("Y-m-d H:i:s");
			
					$id = $ins_ipfDB1->dataControl("insert", $_DATA);
				}
                
                unset($_DATA);
	 			$_DATA = array();
                $_DATA['article_c_tag']['tag_id'] = $id;
                $_DATA['article_c_tag']['article_id'] = $_GET["aid"];
                $ins_ipfDB1->dataControl("insert", $_DATA);
				
			}
		}
        
		$_DATA = array();
		$_DATA['article']['categroy'] = implode(',', $_POST['category']);
		$_DATA['article']['title'] = $_POST['title'];
		$_DATA['article']['entry_name'] = $_POST['entry_name'];
		$_DATA['article']['client_url'] = $_POST['client_url'];
		if($_POST["up_img"]!=""){
			$_DATA['article']['image'] = $_POST["up_img"];
		}
		$_DATA['article']['contents'] = $_POST['contents'];
		$_DATA['article']['terminal'] = 1;
		$_DATA['article']['links'] = $_POST["links"];
		$_DATA['article']['source_name'] = $_POST["source_name"];
        //$_DATA['article']['tag'] = $resultTagId;
		if($_POST["pay_flag"]==1){
			$_DATA['article']['pay_flag'] = $_POST["pay_flag"];
		}else{
			$_DATA['article']['pay_flag'] = 0;
		}
		$_DATA['article']['is_outsource'] = $_POST["kiji_type"];
// 		$_DATA['article']['addtime'] = date('Y-m-d H:i:s');
		$_DATA['article']['writer_id'] = $_POST["write_id"];
        $_DATA['article']['access_num'] = $_POST["pv"];
        
		$ins_ipfDB1->dataControl("update", "id = ".$_GET["aid"]);
		
		if($_POST['postToFb']){
			//echo "nick = ".$_POST['username'];
			$APP_ID = '472840046118382';
			$SECRET_KEY = '670879442476c45806d5aa546c6003b1';
			$ACCESS_TOKEN = 'CAAGuC6b8Be4BACZCOss2F9MEcuxTOmXpzZCxXCiPYClEfpXfCmCAbBHJFVhIpZCm0FEOZAUSLwZB8q0JfU2NqIvqRdioiCwvtBnDQQjwZBCyIKJ5x9oVTckUKeMjeH40mjLpAwYxcd8eod1tiASwPNjNoMp1Eym8aa7TALZBl3sRYDmnHz19hQ6yg1V5PeWuwoZD';
	
			$config = array();
			$config['appId'] = $APP_ID;
			$config['secret'] = $SECRET_KEY;

			$fb = new Facebook($config);
		//CAAGuC6b8Be4BACZCOss2F9MEcuxTOmXpzZCxXCiPYClEfpXfCmCAbBHJFVhIpZCm0FEOZAUSLwZB8q0JfU2NqIvqRdioiCwvtBnDQQjwZBCyIKJ5x9oVTckUKeMjeH40mjLpAwYxcd8eod1tiASwPNjNoMp1Eym8aa7TALZBl3sRYDmnHz19hQ6yg1V5PeWuwoZD
		//general
		//"message" => "TiARYプレスに新しい記事が投稿されました。\n\n\n".$_POST['title'],
		//CAAGuC6b8Be4BAJEbEulL8OvmKb64biOZBSZAusWWZBq2kAzI2ALywLX44HIGsDrQ1WbhYUJYZCqbqexErONZC0PyZCHXZBWX7BhmskzOTGC83i1k0IhaclsgW1MUlRdZAq0C2X1t3nWu7xqm9Wd4pZCoEcVFZBqmnsAMzhneZCuyWJKYMSXEa4N0QPbaU7lZBcii4NQZD
			$params = array(
			  // this is the main access token (facebook profile)
			  "access_token" => $ACCESS_TOKEN,
			  "message" => "TiARYプレスに新しい記事が投稿されました。",
			  "link" => "http://model.tiary.jp/read.php?aid=".$_GET["aid"],
			  "picture" => ($_POST["up_img"]!=""?"".$_POST["up_img"]:"http://tiary.jp/img/startyfree.jpg"),
			  "name" => "".$_POST['title'],
			  "caption" => ($_POST["up_img"]!=""?"".$_POST["up_img"]:"http://tiary.jp/img/startyfree.jpg"),
			  "description" => "".$_POST['contents']
			);
	
			try {
				$fb->api('158856827601174/feed', 'post', $params);
				//header('Location: invite_test1234.php');
			}
			catch(Exception $e) {
				// print "<pre>";
		//  		print_r($e);
		//  		print "</pre>";
				$to      = 'nelson@starty-in.jp';
				$subject = 'FB ERROR CONNECT';
				$message = $e;
				$headers = 'From: TiARYMODELFBConnect@tiary-model.com' . "\r\n" .
					'Reply-To: TiARYMODELFBConnect@tiary-model.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);
			}
		}
		
		
		header('Location: main.php');
	}else{
		$PAGE_VALUE["title"] = $_POST["title"];
		$PAGE_VALUE["up_img"] = $_POST["up_img"];
		$PAGE_VALUE["contents"] = $_POST["contents"];
		$PAGE_VALUE["links"] = $_POST["links"];
		$PAGE_VALUE["entry_name"] = $_POST["entry_name"];
		if($_POST["pay_flag"]==1){
			$PAGE_VALUE["pay_flag_checked"] = 'checked="checked"';
		}
		if($_POST["postToFb"]==1){
			$PAGE_VALUE["postToFbChecked"] = 'checked="checked"';
		}
        $PAGE_VALUE["tag"] = $_POST["tag"];
	}
}

バレンタインデーが終わり、気持ちを伝えられた人もそうでない人も結果はどうあれ２月１４日は特別な日になったはず。
そこで今回は、気持ちを伝えれなかった女子が「今からでもまだ遅くない！？」彼のハートを鷲掴みできる方法を伝授しちゃいます！

【チョコ？クッキー？想いを形にして贈るサプライズ！】
女子が喜ぶ定番のサプライズと言えば、
・東京タワーでDJがメッセージを
・年の数だけのプレゼントを贈る
・リムジンに乗ってからレストランでお食事
なかなか経験できない機会ですが、とてもじゃないけど今時の男子には勇気もなければお金もない。
男子ができない事が、女子なら尚更できないですよね。
でも気軽にできて、恥ずかしがり屋でも彼氏をキュン死にさせちゃう、新しいサプライズの定番になりそうなものがありました↓

<iframe width="560" height="315" src="https://www.youtube.com/embed/Cgz8sRxSYj4" frameborder="0" allowfullscreen></iframe>

【彼へ贈るサプライズメッセージ】
贈り方は様々♪
・携帯へ送る
・DVDで贈る
・デジタルフォトフレームで贈る
・DVD+デジフォトで贈る
販売価格(税込)7,500-19,280円
URL：http://choco-video.com/

男子は手作りチョコやクッキーをもらえると想像しているはず。
でもホワイトデーの事を忘れたふりをして、いつも通りデートを楽しんじゃって、
何事もなかったように帰り際に、メールを送る作戦。
そのメールにはURLを張り付けて、メールを開くと彼女から。
その先はご想像にお任せします♪

BGMを入れる事ができるみたいで、２人の思い出の曲をチョイスできる点も魅力。
後輩女子からもらったらキュン死に間違いないですよね(*^_^*)

【サプライズは気持が伝わるかが一番】
私も様々なサプライズを決行してきましたが、
されて微妙な反応をされたことは一度もありません。
される方もされた方も両方微笑ましい気持ちになります。
毎年様々な工夫を凝らしますが、気持ちが伝わることが大事で、
手の届かなかった彼にサプライズしてみたら、案外コロッと落ちちゃうかも♡
ちなみに私が貰って一番うれしいのはDVDかな♪
貰ったDVDを何度も何度も再生して、一緒に照れてる彼を想像しただけでニヤけものです。

是非チェックしてみてください^^
この記事が気になった方は
↓こちらから
<a href="http://model.tiary.jp/ad.php?ad=6631" target="_blank"><img src="http://choco-video.com/upload/save_image/05261742_5382fe620ccac.jpg" width="200"></a>

↓ホワイトデー用のお得な割引も行っているみたいでした^^

ホワイトデークーポンコード
＜cae2098＞



//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>