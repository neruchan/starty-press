<?php
if($_POST['k_flag']!=""){
	$error_flag = 2;
}

$error_flag = 0;

if($_POST['send_flag']){
	//お名前
	if($_POST["names"] ==""){
		$names_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}else{
// 		mb_regex_encoding("UTF-8");
// 		if(!preg_match("/^[ぁ-んァ-ヶー一-龠]+$/u",$_POST["names"])) {
// 			$names_err ='<p class="err">※ 正しく入力してください。</p>';
// 			$error_flag = 1;
// 		}
	}

	if($_POST["mail"] ==""){
		$mail_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}else{
		if($_POST["mail"] !=""){
			if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_POST["mail"])){
				$mail_err ='<p class="err">※ 正しく入力してください。</p>';
				$error_flag = 1;
			}
		}
	}

	//問い合わせ
	if($_POST["purpose"]==""){
		$purpose_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}
	if($error_flag!=1){
		require_once "contact_confirm.php";
		exit;
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>お問い合わせ｜STARTY Press（スターティープレス）―TV番組連動型プレスリリース配信サイト―</title>
<meta name="description" content="お問い合わせページです。フォームにご入力の上、送信してください。">
<meta name="keywords" content="お問い合わせ,リリース,ニュースリリース,配信サービス,配信サイト,ＴＶメディア,配信代行,STARTY Press">
<link rel="stylesheet" href="css/common.css" type="text/css">
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script src="js/scrolling.js"></script>
<script src="js/jquery.js"></script>
<script>
$(function(){
	$("#check_btn").click(function(){
		$("#check_form").submit();
	});

});

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45497052-1', 'startyjapan.jp');
  ga('send', 'pageview');

</script>

</head>

<body>


<?php include 'ppc_tag1.php'; ?>

<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->

<?php include_once("analyticstracking.php") ?>


<?php include './common/header.php'; ?>

<div id="wrapper"> 
<div id="mainbase"> 



<!--main area start-->
<div class="content">
<h2>お問い合わせ</h2>

<div align="center">
<form action="" id="check_form" method="post">
<table width="94%">
<tr>
<td class="table-head02" valign="top">お名前&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body02" valign="top"><input type="text" class="form01b" name="names" value="<?php echo $_POST["names"]?>"><?php echo $names_err?></td>
</tr>
<tr>
<td class="table-head02" valign="top">メールアドレス&nbsp;<img src="img/img06.png" alt=""  ></td>
<td class="table-body02" valign="top"><input type="text" class="form01b" name="mail" value="<?php echo $_POST["mail"]?>"><?php echo $mail_err?></td>
</tr>
<tr>
<td class="table-head02" valign="top">電話番号</td>
<td class="table-body02" valign="top"><input type="text" class="form01b" name="tel" value="<?php echo $_POST["tel"]?>"></td>
</tr>
<tr>
<td class="table-head02" valign="top">お問い合わせ内容&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body02" valign="top"><textarea class="form03b" name="purpose" rows="20" ><?php echo $_POST["purpose"]?></textarea><?php echo $purpose_err?></td>
</tr>
</table>
<input type="hidden" name="send_flag" value="send_flag" />
</form>
</div>

<br><br>

<p align="center"><a href="javascript:void(0)" id="check_btn"><img src="img/btn07.png" alt=""></a></p>

</div>
<!--main area end-->

</div><!--mainbase end--> 
<?php include './common/sidebar.php'; ?>
</div><!--wrapper end--> 


<?php include './common/footer.php'; ?>

<!-- Google Code for click to call Conversion Page
In your html page, add the snippet and call
goog_report_conversion when someone clicks on the
phone number link or button. -->
<script type="text/javascript">
  /* <![CDATA[ */
  goog_snippet_vars = function() {
    var w = window;
    w.google_conversion_id = 987864850;
    w.google_conversion_label = "uWWPCI6HxAkQkr6G1wM";
    w.google_conversion_value = 0;
    w.google_remarketing_only = false;
  }
  // DO NOT CHANGE THE CODE BELOW.
  goog_report_conversion = function(url) {
    goog_snippet_vars();
    window.google_conversion_format = "3";
    window.google_is_call = true;
    var opt = new Object();
    opt.onload_callback = function() {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  }
  var conv_handler = window['google_trackConversion'];
  if (typeof(conv_handler) == 'function') {
    conv_handler(opt);
  }
}
/* ]]> */
</script>
<script type="text/javascript"
  src="//www.googleadservices.com/pagead/conversion_async.js">
</script>

<script type="text/javascript" language="javascript">
var yahoo_retargeting_id = 'WE66EASGVT';
var yahoo_retargeting_label = '';
</script>
<script type="text/javascript" language="javascript" src="//b92.yahoo.co.jp/js/s_retargeting.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 987864850;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/987864850/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<!-- ClickTale Bottom part -->

<script type='text/javascript'>
// The ClickTale Balkan Tracking Code may be programmatically customized using hooks:
// 
//   function ClickTalePreRecordingHook() { /* place your customized code here */  }
//
// For details about ClickTale hooks, please consult the wiki page http://wiki.clicktale.com/Article/Customizing_code_version_2

document.write(unescape("%3Cscript%20src='"+
(document.location.protocol=='https:'?
"https://clicktalecdn.sslcs.cdngc.net/www02/ptc/04cb1493-96e1-4b27-a05a-bc62093b960f.js":
"http://cdn.clicktale.net/www02/ptc/04cb1493-96e1-4b27-a05a-bc62093b960f.js")+"'%20type='text/javascript'%3E%3C/script%3E"));
</script>

<!-- ClickTale end of Bottom part -->

<?php include 'ppc_tag2.php'; ?>

</body>
</html>
