<?php
if($_POST['k_flag']){
	//メール内容
	mb_language("ja");
	mb_internal_encoding("UTF-8");
	$txt ='・商号
'.$_POST["trade_name"].'

・商号（カナ）
'.$_POST["trade_name_gana"].'

・商号（英文）
'.$_POST["trade_name_en"].'

・WEBサイトURL
'.$_POST["home_page"].'

・業種
'.$_POST["business_category"].'

・業務内容
'.$_POST["business"].'

・本社所在地
〒'.$_POST["postal_top3"].'-'.$_POST["postal_bot4"].' '.$_POST["pref"].'　'.$_POST["address"].'

・電話番号
'.$_POST["tel"].'

・FAX番号
'.$_POST["fax"].'

・資本金
'.$_POST["capital"].'

・上場
'.$_POST["stocks"].'

・従業員数
'.$_POST["employee"].'

・設立年月
'.($_POST["set_year"]!=""?$_POST["set_year"]."年":"").($_POST["set_year"]!=""?$_POST["set_month"]."月":"").($_POST["set_date"]!=""?$_POST["set_year"]."日":"").'

・担当者名
'.$_POST["charge_name"].'

・部署
'.$_POST["station"].'

・メールアドレス
'.$_POST["mail"].'

			';
	//送信メールアドレス
	//info@startyjapan.jp
	$to='ppc@starty-in.jp,kondo@starty-in.jp,kato@starty-in.jp,nobuhara@starty-in.jp,info@startyjapan.jp,info@starty.jp,tokyo.media@starty-in.jp';
	
	//$to='tao.tao@starty-in.jp,nobuhara@starty-in.jp,info@startyjapan.jp,info@starty.jp';
	//メールタイトル
	$subject = 'STARTY Press プレスリリース配信会員登録フォームよりお問い合わせがありました。';
	// 	$subject = mb_convert_encoding($subject, "ISO-2022-JP","utf-8");
	// 	$subject = mb_encode_mimeheader($subject,"ISO-2022-JP");
	$subject = mb_convert_encoding($subject, "JIS", 'utf-8');
	$subject = base64_encode($subject);
	$subject = '=?ISO-2022-JP?B?' . $subject . '?=';
	$fromname = mb_convert_encoding("【STARTY Press運営事務局】", "ISO-2022-JP","utf-8");
	$fromname = mb_encode_mimeheader($fromname,"ISO-2022-JP");
	$headers='From:<'.$_POST["mail"].'>' . "\r\n" ;
	$headers = mb_convert_encoding($headers, "ISO-2022-JP","utf-8");
	$txt = mb_convert_encoding($txt, "ISO-2022-JP","utf-8");
	mail($to,$subject,$txt,$headers);

	//送信メールアドレス
	$to1= $_POST["mail"];
	//メールタイトル
	$subject1 = '【STARTY Press運営事務局】お問い合わせいただきありがとうございます。';
	$subject1 = mb_convert_encoding($subject1, "JIS", 'utf-8');
	$subject1 = base64_encode($subject1);
	$subject1 = '=?ISO-2022-JP?B?' . $subject1 . '?=';
// 	$subject1 = mb_convert_encoding($subject1, "ISO-2022-JP","utf-8");
// 	$subject1 = mb_encode_mimeheader($subject1,"ISO-2022-JP");
	//メール内容
	$txt1 ='STARTY Pressにお問い合わせいただきありがとうございます。
下記ＨＰよりお問い合わせいただいた内容になります。
担当者より追ってご連絡させていただきます今しばらくお待ちください。

・商号
'.$_POST["trade_name"].'

・商号（カナ）
'.$_POST["trade_name_gana"].'

・商号（英文）
'.$_POST["trade_name_en"].'

・WEBサイトURL
'.$_POST["home_page"].'

・業種
'.$_POST["business_category"].'

・業務内容
'.$_POST["business"].'

・本社所在地
〒'.$_POST["postal_top3"].'-'.$_POST["postal_bot4"].' '.$_POST["pref"].'　'.$_POST["address"].'

・電話番号
'.$_POST["tel"].'

・FAX番号
'.$_POST["fax"].'

・資本金
'.$_POST["capital"].'

・上場
'.$_POST["stocks"].'

・従業員数
'.$_POST["employee"].'

・設立年月
'.($_POST["set_year"]!=""?$_POST["set_year"]."年":"").($_POST["set_year"]!=""?$_POST["set_month"]."月":"").($_POST["set_date"]!=""?$_POST["set_year"]."日":"").'

・担当者名
'.$_POST["charge_name"].'

・部署
'.$_POST["station"].'

・メールアドレス
'.$_POST["mail"].'

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
<title>STARTY Press|ＴＶ番組連動型プレスリリース配信サイト</title>
<meta name="description" content="お客様のプレスリリースやニュースリリースを各メディア・マスコミにお届けし貴社の販売促進・広報活動を支援することを目的とした総合PRサービスです。">
<meta name="keywords" content="リリース,ニュースリリース,配信サービス,配信サイト,ＴＶメディア,配信代行,STARTY Press,無料">
<link rel="stylesheet" href="css/common.css" type="text/css">
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script src="js/scrolling.js"></script>
<script src="js/jquery.js"></script>
<script type="text/javascript">
$(function () {
 
  var msie6 = $.browser == 'msie' && $.browser.version < 7;
  if (!msie6) {
    var top = $('.navi-right').offset().top;
    $(window).scroll(function (event) {
      var y = $(this).scrollTop();
      if (y >= top) { $('.navi-right').addClass('fixed'); }
      else { $('.navi-right').removeClass('fixed'); }
    });
  }
});
</script>
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
<h2>プレスリリース配信会員登録フォーム</h2>

<p>現在、STARTY Pressでは、正式サイトオープンに向け、プレスリリース受信をご希望の方を募集しています。</p>

<p class="sub-head"><img src="img/arrow02.png" alt="">&nbsp;企業情報</p>

<table width="94%">
<tr>
<td class="table-head" valign="top">商号&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><?php echo $_POST["trade_name"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">商号（カナ）&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><?php echo $_POST["trade_name_gana"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">商号（英文）</td>
<td class="table-body" valign="top"><?php echo $_POST["trade_name_en"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">WEBサイトURL</td>
<td class="table-body" valign="top"><?php echo $_POST["home_page"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">業種&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><?php echo $_POST["business_category"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">業務内容</td>
<td class="table-body" valign="top"><?php echo $_POST["business"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">本社所在地&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top">
〒<?php echo $_POST["postal_top3"]?>-<?php echo $_POST["postal_bot4"]?> <?php echo $_POST["pref"]?>　<?php echo $_POST["address"]?>
</td>
</tr>
<tr>
<td class="table-head" valign="top">電話番号&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><?php echo $_POST["tel"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">FAX番号</td>
<td class="table-body" valign="top"><?php echo $_POST["fax"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">資本金&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><?php echo $_POST["capital"]?>万円</td>
</tr>
<tr>
<td class="table-head" valign="top">上場</td>
<td class="table-body" valign="top"><?php echo $_POST["stocks"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">従業員数</td>
<td class="table-body" valign="top"><?php echo ($_POST["employee"]!=""?$_POST["employee"]."人":"")?></td>
</tr>
<tr>
<td class="table-head" valign="top">設立年月</td>
<td class="table-body" valign="top"><?php echo ($_POST["set_year"]!=""?$_POST["set_year"]."年":"")?><?php echo ($_POST["set_month"]!=""?$_POST["set_month"]."月":"")?><?php echo ($_POST["set_date"]!=""?$_POST["set_date"]."日":"")?></td>
</tr>
</table>


<p class="sub-head"><img src="img/arrow02.png" alt="">&nbsp;担当者情報 <span class="orange-small">(非表示）</span></p>

<table>
<tr>
<td class="table-head" valign="top">担当者名&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><?php echo $_POST["charge_name"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">部署&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><?php echo $_POST["station"]?></td>
</tr>
<tr>
<td class="table-head" valign="top">メールアドレス&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><?php echo $_POST["mail"]?></td>
</tr>
</table>
<form action="" method="post" id="myForm" name="myForm">
	<input type="hidden" name="trade_name" value="<?php echo $_POST['trade_name']?>"/>
	<input type="hidden" name="trade_name_gana" value="<?php echo $_POST['trade_name_gana']?>"/>
	<input type="hidden" name="trade_name_en" value="<?php echo $_POST['trade_name_en']?>"/>
	<input type="hidden" name="home_page" value="<?php echo $_POST['home_page']?>"/>
	<input type="hidden" name="business_category" value="<?php echo $_POST['business_category']?>"/>
	<input type="hidden" name="business" value="<?php echo $_POST['business']?>"/>
	<input type="hidden" name="postal_top3" value="<?php echo $_POST['postal_top3']?>"/>
	<input type="hidden" name="postal_bot4" value="<?php echo $_POST['postal_bot4']?>"/>
	<input type="hidden" name="pref" value="<?php echo $_POST['pref']?>"/>
	<input type="hidden" name="address" value="<?php echo $_POST['address']?>"/>
	<input type="hidden" name="tel" value="<?php echo $_POST['tel']?>"/>
	<input type="hidden" name="fax" value="<?php echo $_POST['fax']?>"/>
	<input type="hidden" name="capital" value="<?php echo $_POST['capital']?>"/>
	<input type="hidden" name="stocks" value="<?php echo $_POST['stocks']?>"/>
	<input type="hidden" name="employee" value="<?php echo $_POST['employee']?>"/>
	<input type="hidden" name="set_year" value="<?php echo $_POST['set_year']?>"/>
	<input type="hidden" name="set_month" value="<?php echo $_POST['set_month']?>"/>
	<input type="hidden" name="set_date" value="<?php echo $_POST['set_date']?>"/>
	<input type="hidden" name="charge_name" value="<?php echo $_POST['charge_name']?>"/>
	<input type="hidden" name="station" value="<?php echo $_POST['station']?>"/>
	<input type="hidden" name="mail" value="<?php echo $_POST['mail']?>"/>
	<input type="hidden" name="k_flag" value="k_flag"/>
</form>
<br><br>

<p align="center"><a href="javascript:void(0)" onClick="send('form.php')"><img src="img/btn03.png" alt=""></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onClick="send('confirm.php')"><img src="img/btn04.png" alt=""></a></p>

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


<?php include 'ppc_tag2.php'; ?>

</body>
</html>
