<?php
/*
 *ファイル名 : write.php
 * 機能名    : 記事新規登録ページ
 * 作成者    : トウ
 * 作成日    : 13/08/09
 */

/***********************
* 定義
***********************/
require_once "tiary/ipfTemplate.php";
require_once "startypress/ipfDB1.php";
require_once 'src/facebook.php';
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
$template_file = "write2.template";
$PAGE_VALUE["title"] = "";
$PAGE_VALUE["up_img"] = "";
$PAGE_VALUE["contents"] = "";
$PAGE_VALUE["links"] = "http://";
$PAGE_VALUE["source_name"] = "";
$PAGE_VALUE["entry_name"] = "";
$PAGE_VALUE[article_img_err] = "";
$PAGE_VALUE[title_err] = "";
$PAGE_VALUE[category_err] ="";
$PAGE_VALUE[contents_err] ="";
$PAGE_VALUE[writer_id_err] ="";
$PAGE_VALUE['link_err'] = "";
$PAGE_VALUE["pay_flag_checked"] = '';
$PAGE_VALUE["postToFbChecked"] = '';

session_start();
if(!$_SESSION["admin"]){
	header('Location: index.php');
}

$PAGE_VALUE["category_checkbox"] = setCheckboxArticle($new_article_categorys,($_POST["category"]!=""?implode(",", $_POST["category"]):$_POST["category"]));


if($_POST["add_flag"]!=""){

	$error_flag = 0;
	if($_FILES['article_img']['tmp_name'] != ''){
		$uploaddir = '/var/www/vhosts/model.tiary.jp/httpdocs/pjpic';
		$basename = basename($_FILES['article_img']['tmp_name']);
		$fileext = strrchr($_FILES['article_img']['name'], '.');
		$filename = $basename . $fileext;
		$uploadfile = $uploaddir . "/" . $filename;
		$is_uploaded = move_uploaded_file($_FILES['article_img']['tmp_name'], $uploadfile);
		$_POST["up_img"] = "http://model.tiary.jp/pjpic/".$filename;
	}else{
		$PAGE_VALUE[article_img_err] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}

	
	if($_POST["title"] ==""){
		$PAGE_VALUE['title_err'] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	if($_POST["links"] ==""){
		$PAGE_VALUE['link_err'] ='<tr><td></td><td><p class="red">※必須項目です。正しくご入力ください。</p></td></tr>';
		$error_flag = 1;
	}
	elseif(mb_strlen($_POST["title"], 'UTF-8') > 80){
		$PAGE_VALUE['title_err'] ='<tr><td></td><td><p class="red">※80文字以内で入力してください。</p></td></tr>';
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
// 		echo "<br/>title length = ".mb_strlen($_POST["title"], 'UTF-8');
// 		echo "<br/>content length = ".mb_strlen($_POST["contents"], 'UTF-8');
// 		echo "<br/><br/>category".implode(',', $_POST['category']);
// 		echo "<br/><br/>title".$_POST['title'];
// 		echo "<br/><br/>image".$_POST["up_img"];
// 		echo "<br/><br/>contents".$_POST['contents'];
// 		echo "<br/><br/>entry_name".$_POST["entry_name"];
		
	
		$_DATA = array();
		$_DATA['article']['categroy'] = implode(',', $_POST['category']);
		$_DATA['article']['title'] = $_POST['title'];
		$_DATA['article']['image'] = $_POST["up_img"];
		$_DATA['article']['contents'] = $_POST['contents'];
		$_DATA['article']['terminal'] = 1;
		$_DATA['article']['links'] = $_POST["links"];
		$_DATA['article']['source_name'] = $_POST["source_name"];
		$_DATA['article']['addtime'] = date('Y-m-d H:i:s');
		
		$_DATA['article']['is_outsource'] = 1;
		
		$entry_id = $ins_ipfDB1->dataControl("insert", $_DATA);
		
		
		if($_POST['postToFb']){
			Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
			//echo "nick = ".$_POST['username'];
			$APP_ID = '472840046118382';
			$SECRET_KEY = '670879442476c45806d5aa546c6003b1';
			$ACCESS_TOKEN = 'CAAGuC6b8Be4BAN7i6eVRnE9xo7ZAP60HyQXBL6MPiuWulHZAK2GpE56kJnNpLEDbNNYL49FvJc16vYo2ZCGxLv9bbvIUVRkkZBANDX9PR66F8ZB8zs4qC7cwxLRIx8UEd8ObVqHMruba9cxiB8DpWacMoApqVFwjV1HqA7K7rL3V6W62X5Uby9lAHbQ2bITTq8KiRWkwmmbNA4WENa33l';
			//$ACCESS_TOKEN = 'CAAGuC6b8Be4BACZCOss2F9MEcuxTOmXpzZCxXCiPYClEfpXfCmCAbBHJFVhIpZCm0FEOZAUSLwZB8q0JfU2NqIvqRdioiCwvtBnDQQjwZBCyIKJ5x9oVTckUKeMjeH40mjLpAwYxcd8eod1tiASwPNjNoMp1Eym8aa7TALZBl3sRYDmnHz19hQ6yg1V5PeWuwoZD';
//            $ACCESS_TOKEN = 'CAAGuC6b8Be4BAMscXESH4rGPz5dLzq6yES1OGF7ALkM3PbZBMJjV0hnZBTj5ZAXQZBy2RXElpykn0VUpVFooqHGlbzGZBq39GwiZBKNHDSI1xzcgjggaKdjZANPegai6SZAh4Qy2DmEMqKcW6hwb615LLOBnRXRWZBQ0awSpJSaBnMCy3xwrm5xv45HG54eWPLZAEPWLn12oBB0RjcRzLv0Erw';
           
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
			  //"message" => "TiARYプレスに新しい記事が投稿されました。\n\n\n".$_REQUEST['title'],
			  "message" => $_REQUEST['title'],
			  "link" => "http://press.tiary.jp/read.php?aid=".$entry_id,
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
	
		
		header('Location: main.php?t='.$test);
	}else{
		$PAGE_VALUE["title"] = $_POST["title"];
		
		$PAGE_VALUE["up_img"] = $_POST["up_img"];
		$PAGE_VALUE["contents"] = $_POST["contents"];
		$PAGE_VALUE["links"] = $_POST["links"];
		$PAGE_VALUE["source_name"] = $_POST["source_name"];
	}
}

//テンプレートファイルの読込
$templateData = $ins_ipfTemplate->loadTemplate($template_file);
$templateData = $ins_ipfTemplate->makeTemplateData($templateData, $PAGE_VALUE, $valuesForLoop);
$ins_ipfTemplate->putMemory($templateData);
$ins_ipfTemplate->view();
?>