<?php
if($_POST['k_flag']){
	//メール内容
	mb_language("ja");
	mb_internal_encoding("UTF-8");
	$txt ='・名前
'.$_POST["names"].'

・メールアドレス
'.$_POST["mail"].'

・電話番号
'.$_POST["tel"].'

・お問い合わせ内容
'.$_POST["purpose"].'

			';
	//送信メールアドレス
	//info@startyjapan.jp
	$to='ppc@starty-in.jp,kondo@starty-in.jp,kato@starty-in.jp,nobuhara@starty-in.jp,info@startyjapan.jp,info@starty.jp,tokyo.media@starty-in.jp';
	//$to='tao.tao@starty-in.jp,nobuhara@starty-in.jp,info@startyjapan.jp,info@starty.jp';
	//メールタイトル
	$subject = 'STARTY Pressよりお問い合わせがありました。';
	// 	$subject = mb_convert_encoding($subject, "ISO-2022-JP","utf-8");
	// 	$subject = mb_encode_mimeheader($subject,"ISO-2022-JP");
	$subject = mb_convert_encoding($subject, "JIS", 'utf-8');
	$subject = base64_encode($subject);
	$subject = '=?ISO-2022-JP?B?' . $subject . '?=';
	$fromname = mb_convert_encoding("【Starty Press運営事務局】", "ISO-2022-JP","utf-8");
	$fromname = mb_encode_mimeheader($fromname,"ISO-2022-JP");
	$headers='From:<'.$_POST["mail"].'>' . "\r\n" ;
	$headers = mb_convert_encoding($headers, "ISO-2022-JP","utf-8");
	$txt = mb_convert_encoding($txt, "ISO-2022-JP","utf-8");
	mail($to,$subject,$txt,$headers);

	//送信メールアドレス
	$to1= $_POST["mail"];
	//メールタイトル
	$subject1 = '【Starty Press運営事務局】お問い合わせいただきありがとうございます。';
	$subject1 = mb_convert_encoding($subject1, "JIS", 'utf-8');
	$subject1 = base64_encode($subject1);
	$subject1 = '=?ISO-2022-JP?B?' . $subject1 . '?=';
// 	$subject1 = mb_convert_encoding($subject1, "ISO-2022-JP","utf-8");
// 	$subject1 = mb_encode_mimeheader($subject1,"ISO-2022-JP");
	//メール内容
	$txt1 ='STARTY Pressにお問い合わせいただきありがとうございます。
下記ＨＰよりお問い合わせいただいた内容になります。
担当者より追ってご連絡させていただきます今しばらくお待ちください。

・名前
'.$_POST["names"].'

・メールアドレス
'.$_POST["mail"].'

・電話番号
'.$_POST["tel"].'

・お問い合わせ内容
'.$_POST["purpose"].'

--------------------------------------------
スターティーインターナショナル株式会社
STARTY Press運営事務局
info@startyjapan.jp

〒106-0047
東京都港区南麻布4-14-6　 バルビゾン34 6Ｆ
TEL：03-5798-8833
FAX：03-5798-8834
URL：http://startyjapan.jp
--------------------------------------------
			';
	$headers1='From:"'.$fromname.'"<info@startyjapan.jp>' . "\r\n" ;
	$headers1 = mb_convert_encoding($headers1, "ISO-2022-JP","utf-8");
	$txt1 = mb_convert_encoding($txt1, "ISO-2022-JP","utf-8");
	mail($to1,$subject1,$txt1,$headers1);

	header('Location: finish.php');
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>問い合わせ|STARTY Press（スターティープレス）―TV番組連動型プレスリリース配信サイト―</title>
<meta name="description" content="お客様のプレスリリースやニュースリリースを各メディア・マスコミにお届けし貴社の販売促進・広報活動を支援することを目的とした総合PRサービスです。">
<meta name="keywords" content="リリース,ニュースリリース,配信サービス,配信サイト,ＴＶメディア,配信代行,STARTY Press,無料">
<link rel="stylesheet" href="css/common.css" type="text/css">
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script src="js/scrolling.js"></script>
<script src="js/jquery.js"></script>
<script>
function send(i){
	$(document).ready(function(){
		$("#myForm").attr("action",i).submit();
	});
}

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

<?php include_once("analyticstracking.php") ?>
<?php include './common/header.php'; ?>

<div id="wrapper"> 
<div id="mainbase"> 


<!--main area start-->
<div class="content">
<h2>お問い合わせ</h2>

<div align="center">
<table width="94%">
<tr>
<td class="table-head02" valign="top">お名前&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body02" valign="top"><?php echo $_POST["names"]?></td>
</tr>
<tr>
<td class="table-head02" valign="top" nowrap>メールアドレス&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body02" valign="top"><?php echo $_POST["mail"]?></td>
</tr>
<tr>
<td class="table-head02" valign="top">電話番号</td>
<td class="table-body02" valign="top"><?php echo $_POST["tel"]?></td>
</tr>
<tr>
<td class="table-head02" valign="top">お問い合わせ内容&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body02" valign="top"><?php echo nl2br($_POST["purpose"])?></td>
</tr>
</table>
</div>

<br><br>
<form action="" method="post" id="myForm" name="myForm">
<input type="hidden" name="names" value="<?php echo $_POST['names']?>"/>
	<input type="hidden" name="tel" value="<?php echo $_POST['tel']?>"/>
	<input type="hidden" name="purpose" value="<?php echo $_POST['purpose']?>"/>
	<input type="hidden" name="mail" value="<?php echo $_POST['mail']?>"/>
	<input type="hidden" name="k_flag" value="k_flag"/>
    </form>
<p align="center"><a href="javascript:void(0)" onClick="send('contact.php')"><img src="img/btn03.png" alt=""></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onClick="send('contact_confirm.php')"><img src="img/btn04.png" alt=""></a></p>

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


</body>
</html>
