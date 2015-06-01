<?php
include_once 'define.php';

$error_flag = 0;

$show_pref = setPulldown($prefs,$_POST["pref"]);

$show_set_year = setPulldown($years,$_POST["set_year"]);
$show_set_month = setPulldown($months,$_POST["set_month"]);
$show_set_date = setPulldown($dates,$_POST["set_date"]);

$show_business_category = setPulldown($business_categorys,$_POST['business_category']);



if($_POST['k_flag']!=""){
	$error_flag = 2;
}

if($_POST['send_flag']){
	//商号
	if($_POST["trade_name"] ==""){
		$trade_name_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}

	//商号（カナ）
	if($_POST["trade_name_gana"] ==""){
		$trade_name_gana_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}

	//職種
	if($_POST["business_category"] ==""){
		$business_category_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}

	//郵便番号
	if($_POST["postal_top3"] =="" || $_POST["postal_bot4"] ==""){
		$postal_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}

	//都道府県
	if($_POST["pref"] ==""){
		$pref_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}

	//住所
	if($_POST["address"] ==""){
		$address_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}

	//電話番号
	if($_POST["tel"] ==""){
		$tel_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}else{
		if(!preg_match("/^[0-9\-]+$/", $_POST["tel"])){
			$tel_err ='<p class="orange-small">※正しく入力してください。</p>';
			$error_flag = 1;
		}
	}

	//資本金
	if($_POST["capital"] ==""){
		$capital_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}

	//担当者名
	if($_POST["charge_name"] ==""){
		$charge_name_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}else{
// 		mb_regex_encoding("UTF-8");
// 		if(!preg_match("/^[ぁ-んァ-ヶー一-龠]+$/u",$_POST["names"])) {
// 			$names_err ='<p class="err">※ 正しく入力してください。</p>';
// 			$error_flag = 1;
// 		}
	}

	//部署
	if($_POST["station"] ==""){
		$station_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}

	//メールアドレス
	if($_POST["mail"] ==""){
		$mail_err ='<p class="orange-small">※正しく入力してください。</p>';
		$error_flag = 1;
	}else{
		if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_POST["mail"])){
			$mail_err ='<p class="err">※ 正しく入力してください。</p>';
			$error_flag = 1;
		}
	}

	if($error_flag!=1){
		require_once "confirm.php";
		exit;
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>プレスを配信したい方｜STARTY Press（スターティープレス）―TV番組連動型プレスリリース配信サイト―</title>
<meta name="description" content="プレスを配信したい方向けのお問い合わせページです。フォームにご入力の上、送信してください。">
<meta name="keywords" content="プレスリリース配信,リリース,ニュースリリース,配信サービス,配信サイト,ＴＶメディア,配信代行,STARTY Press">
<link rel="stylesheet" href="css/common.css" type="text/css">
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script src="js/scrolling.js"></script>
<script src="js/jquery.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45497052-1', 'startyjapan.jp');
  ga('send', 'pageview');

</script>


<script>
$(function(){
	$("#check_btn").click(function(){
		$("#check_form").submit();
	});

});

</script>

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
AjaxZip3 = function(){};
AjaxZip3.VERSION = '0.4';
AjaxZip3.JSONDATA = 'http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/zipdata';
AjaxZip3.CACHE = [];
AjaxZip3.prev = '';
AjaxZip3.nzip = '';
AjaxZip3.fzip1 = '';
AjaxZip3.fzip2 = '';
AjaxZip3.fpref = '';
AjaxZip3.addr = '';
AjaxZip3.fstrt = '';
AjaxZip3.farea = '';

AjaxZip3.PREFMAP = [
null,       '北海道',   '青森県',   '岩手県',   '宮城県',
'秋田県',   '山形県',   '福島県',   '茨城県',   '栃木県',
'群馬県',   '埼玉県',   '千葉県',   '東京都',   '神奈川県',
'新潟県',   '富山県',   '石川県',   '福井県',   '山梨県',
'長野県',   '岐阜県',   '静岡県',   '愛知県',   '三重県',
'滋賀県',   '京都府',   '大阪府',   '兵庫県',   '奈良県',
'和歌山県', '鳥取県',   '島根県',   '岡山県',   '広島県',
'山口県',   '徳島県',   '香川県',   '愛媛県',   '高知県',
'福岡県',   '佐賀県',   '長崎県',   '熊本県',   '大分県',
'宮崎県',   '鹿児島県', '沖縄県'
];
AjaxZip3.zip2addr = function ( azip1, azip2, apref, aaddr, astrt, aarea ) {
AjaxZip3.fzip1 = AjaxZip3.getElementByName(azip1);
AjaxZip3.fzip2 = AjaxZip3.getElementByName(azip2,AjaxZip3.fzip1);
AjaxZip3.fpref = AjaxZip3.getElementByName(apref,AjaxZip3.fzip1);
AjaxZip3.faddr = AjaxZip3.getElementByName(aaddr,AjaxZip3.fzip1);
AjaxZip3.fstrt = AjaxZip3.getElementByName(astrt,AjaxZip3.fzip1);
AjaxZip3.farea = AjaxZip3.getElementByName(aarea,AjaxZip3.fzip1);

if ( ! AjaxZip3.fzip1 ) return;
if ( ! AjaxZip3.fpref ) return;
if ( ! AjaxZip3.faddr ) return;

// 郵便番号を数字のみ7桁取り出す
//var zipoptimize = function(AjaxZip3.fzip1, AjaxZip3.fzip2){
    var vzip = AjaxZip3.fzip1.value;

    if ( AjaxZip3.fzip2 && AjaxZip3.fzip2.value ) vzip += AjaxZip3.fzip2.value;

    if ( ! vzip ){
     //alert("郵便番号を入力してください");
     return;

    }else if(vzip == 0){
    	alert("該当する郵便番号が見つかりませんでした");
    	return;
    }

    AjaxZip3.nzip = '';
    for( var i=0; i<vzip.length; i++ ) {
        var chr = vzip.charCodeAt(i);
        if ( chr < 48 ) continue;
        if ( chr > 57 ) continue;
        AjaxZip3.nzip += vzip.charAt(i);
    }
    if ( AjaxZip3.nzip.length < 7 ) return;


//};

// 前回と同じ値＆フォームならキャンセル
var uniqcheck = function(){
    var uniq = AjaxZip3.nzip+AjaxZip3.fzip1.name+AjaxZip3.fpref.name+AjaxZip3.faddr.name;
    if ( AjaxZip3.fzip1.form ) uniq += AjaxZip3.fzip1.form.id+AjaxZip3.fzip1.form.name+AjaxZip3.fzip1.form.action;
    if ( AjaxZip3.fzip2 ) uniq += AjaxZip3.fzip2.name;
    if ( AjaxZip3.fstrt ) uniq += AjaxZip3.fstrt.name;
    if ( uniq == AjaxZip3.prev ) return;
    AjaxZip3.prev = uniq;
};


// 郵便番号上位3桁でキャッシュデータを確認
var zip3 = AjaxZip3.nzip.substr(0,3);
var data = AjaxZip3.CACHE[zip3];
if ( data ){
	return AjaxZip3.callback( data );
}

AjaxZip3.zipjsonpquery();

};

AjaxZip3.callback = function(data){

    var array = data[AjaxZip3.nzip];
    // Opera バグ対策：0x00800000 を超える添字は +0xff000000 されてしまう
    var opera = (AjaxZip3.nzip-0+0xff000000)+"";
    if ( ! array && data[opera] ) array = data[opera];

    if ( ! array ){
     alert("該当する郵便番号が見つかりませんでした");
     return;

    }

    var pref_id = array[0];                 // 都道府県ID
    if ( ! pref_id ) return;
    var jpref = AjaxZip3.PREFMAP[pref_id];  // 都道府県名
    if ( ! jpref ) return;
    var jcity = array[1];
    if ( ! jcity ) jcity = '';              // 市区町村名
    var jarea = array[2];
    if ( ! jarea ) jarea = '';              // 町域名
    var jstrt = array[3];
    if ( ! jstrt ) jstrt = '';              // 番地

    var cursor = AjaxZip3.faddr;
    var jaddr = jcity;                      // 市区町村名

    if ( AjaxZip3.fpref.type == 'select-one' || AjaxZip3.fpref.type == 'select-multiple' ) {
        // 都道府県プルダウンの場合
        var opts = AjaxZip3.fpref.options;
        for( var i=0; i<opts.length; i++ ) {
            var vpref = opts[i].value;
            var tpref = opts[i].text;
            opts[i].selected = ( vpref == pref_id || vpref == jpref || tpref == jpref );
        }

    } else {
        if ( AjaxZip3.fpref.name == AjaxZip3.faddr.name ) {
            // 都道府県名＋市区町村名＋町域名合体の場合
            jaddr = jpref + jaddr;
        } else {
            // 都道府県名テキスト入力の場合
            AjaxZip3.fpref.value = jpref;
        }
    }
    if ( AjaxZip3.farea ) {
        cursor = AjaxZip3.farea;

        AjaxZip3.farea.value = jarea;
    } else {
        jaddr += jarea;
    }
    if ( AjaxZip3.fstrt ) {
        cursor = AjaxZip3.fstrt;
        if ( AjaxZip3.faddr.name == AjaxZip3.fstrt.name ) {
            // 市区町村名＋町域名＋番地合体の場合
            jaddr = jaddr + jstrt;
        } else if ( jstrt ) {
            // 番地テキスト入力欄がある場合
            AjaxZip3.fstrt.value = jstrt;

        }
    }
    AjaxZip3.faddr.value = jaddr;

  //  alert("該当する郵便番号が見つかりませんでした");
    // patch from http://iwa-ya.sakura.ne.jp/blog/2006/10/20/050037
    // update http://www.kawa.net/works/ajax/AjaxZip2/AjaxZip2.html#com-2006-12-15T04:41:22Z

    if ( ! cursor ){

    	return;
    }
    if ( ! cursor.value )return;

    var len = cursor.value.length;
    cursor.focus();
    if ( cursor.createTextRange ) {
        var range = cursor.createTextRange();
        range.move('character', len);
        range.select();
    } else if (cursor.setSelectionRange) {
        cursor.setSelectionRange(len,len);
    }

};

//Safari 文字化け対応
//http://kawa.at.webry.info/200511/article_9.html
AjaxZip3.getResponseText = function ( req ) {
var text = req.responseText;
if ( navigator.appVersion.indexOf('KHTML') > -1 ) {
    var esc = escape( text );
    if ( esc.indexOf('%u') < 0 && esc.indexOf('%') > -1 ) {
        text = decodeURIComponent( esc );
    }
}
return text;
}

//フォームnameから要素を取り出す
AjaxZip3.getElementByName = function ( elem, sibling ) {
if ( typeof(elem) == 'string' ) {
    var list = document.getElementsByName(elem);
    if ( ! list ) return null;
    if ( list.length > 1 && sibling && sibling.form ) {
        var form = sibling.form.elements;
        for( var i=0; i<form.length; i++ ) {
            if ( form[i].name == elem ) {
                return form[i];
            }
        }
    } else {
        return list[0];
    }
}
return elem;
}

AjaxZip3.zipjsonpquery = function(){
var url = AjaxZip3.JSONDATA+'/zip-'+AjaxZip3.nzip.substr(0,3)+'.js';
var scriptTag = document.createElement("script");
scriptTag.setAttribute("type", "text/javascript");
scriptTag.setAttribute("src", url);
scriptTag.setAttribute("charset", "UTF-8");
document.getElementsByTagName("head").item(0).appendChild(scriptTag);
//alert(document.getElementsByTagName("head").item(0).appendChild(scriptTag));
};


function zipdata(data){

AjaxZip3.callback(data);
};

$(function(){
	$('#postal_top3').keyup(function(){
		if($("#postal_top3").val().length==3){
			$("#postal_bot4").focus();
		}
	});
	$('#search_zip').click(function(){
		AjaxZip3.zip2addr('postal_top3','postal_bot4','pref','address');
	});
});
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
<h2>プレスリリース配信会員登録フォーム</h2>

<p>現在、STARTY Pressでは、正式サイトオープンに向け、プレスリリース配信をご希望の方を募集しています。<br>
配信方法・料金等につきましては弊社担当営業より追ってご連絡させていただきます。</p>

<p class="sub-head"><img src="img/arrow02.png" alt="">&nbsp;企業情報</p>
<form action="" id="check_form" method="post">
<table width="94%">
<tr>
<td class="table-head" valign="top">商号&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><input type="text" class="form01" name="trade_name" value="<?php echo $_POST["trade_name"]?>"><?php echo $trade_name_err?></td>
</tr>
<tr>
<td class="table-head" valign="top">商号（カナ）&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><input type="text" class="form01" name="trade_name_gana" value="<?php echo $_POST["trade_name_gana"]?>"><?php echo $trade_name_gana_err?></td>
</tr>
<tr>
<td class="table-head" valign="top">商号（英文）</td>
<td class="table-body" valign="top"><input type="text" class="form01" name="trade_name_en" value="<?php echo $_POST["trade_name_en"]?>"></td>
</tr>
<tr>
<td class="table-head" valign="top">WEBサイトURL</td>
<td class="table-body" valign="top"><input type="text" class="form01" name="home_page" value="<?php echo $_POST["home_page"]?>"></td>
</tr>
<tr>
<td class="table-head" valign="top">業種&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><select class="form02" name="business_category">
<option value="">業種を選択</option>
<?php echo $show_business_category?>
</select>
<?php echo $business_category_err?>
</td>
</tr>
<tr>
<td class="table-head" valign="top">業務内容</td>
<td class="table-body" valign="top"><textarea class="form03" name="business"><?php echo $_POST["business"]?></textarea></td>
</tr>
<tr>
<td class="table-head" valign="top">本社所在地&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top">
<input type="text" class="form04b" id="postal_top3" name="postal_top3" value="<?php echo $_POST["postal_top3"]?>" maxlength="3" style="width:50px;"> - <input type="text" class="form04b" id="postal_bot4" name="postal_bot4" value="<?php echo $_POST["postal_bot4"]?>" maxlength="4" style="width:50px;"><a href="javascript:void(0)" id="search_zip"><img src="img/btn01.png" alt=""></a><?php echo $postal_err?><br>
<select class="form02" id="pref" name="pref">
<option value="">都道府県を選択</option>
<?php echo $show_pref?>
</select>
<?php echo $pref_err?><br>
<input type="text" class="form01 mt8" id="address" name="address" value="<?php echo $_POST["address"]?>"><?php echo $address_err?>
</td>
</tr>
<tr>
<td class="table-head" valign="top">電話番号&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><input type="text" class="form02" name="tel" value="<?php echo $_POST["tel"]?>" maxlength="13"><?php echo $tel_err?></td>
</tr>
<tr>
<td class="table-head" valign="top">FAX番号</td>
<td class="table-body" valign="top"><input type="text" class="form02" name="fax" value="<?php echo $_POST["fax"]?>" maxlength="13"></td>
</tr>
<tr>
<td class="table-head" valign="top">資本金&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><input type="text" class="form02" name="capital" value="<?php echo $_POST["capital"]?>" maxlength="8" style="width:100px;">&nbsp;万円<?php echo $capital_err?></td>
</tr>
<tr>
<td class="table-head" valign="top">上場</td>
<td class="table-body" valign="top"><input type="text" class="form01" name="stocks" value="<?php echo $_POST["stocks"]?>"></td>
</tr>
<tr>
<td class="table-head" valign="top">従業員数</td>
<td class="table-body" valign="top"><input type="text" class="form02" name="employee" value="<?php echo $_POST["employee"]?>">&nbsp;人</td>
</tr>
<tr>
<td class="table-head" valign="top">設立年月</td>
<td class="table-body" valign="top">
<select class="form04b" name="set_year">
<option value="" >---</option>
<?php echo $show_set_year?>
</select>&nbsp;年&nbsp;
<select class="form04b" name="set_month">
<option value="">---</option>
<?php echo $show_set_month?>
</select>&nbsp;月&nbsp;
<select class="form04b" name="set_date">
<option value="">---</option>
<?php echo $show_set_date?>
</select>&nbsp;日&nbsp;
</td>
</tr>
</table>


<p class="sub-head"><img src="img/arrow02.png" alt="">&nbsp;担当者情報 <span class="orange-small">(非表示）</span></p>

<table>
<tr>
<td class="table-head" valign="top">担当者名&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><input type="text" class="form01" name="charge_name" value="<?php echo $_POST["charge_name"]?>"><?php echo $charge_name_err?></td>
</tr>
<tr>
<td class="table-head" valign="top">部署&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><input type="text" class="form01" name="station" value="<?php echo $_POST["station"]?>"><?php echo $station_err?></td>
</tr>
<tr>
<td class="table-head" valign="top">メールアドレス&nbsp;<img src="img/img06.png" alt=""></td>
<td class="table-body" valign="top"><input type="text" class="form01" name="mail" value="<?php echo $_POST["mail"]?>"><?php echo $mail_err?></td>
</tr>
</table>
<input type="hidden" name="send_flag" value="send_flag" />
</form>
<br><br>

<p align="center"><a href="javascript:void(0)" id="check_btn"><img src="img/btn02.png" alt=""></a></p>

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
