<?php

$article_categroys = array(
	'1'=>'ピックアップ',
	'2'=>'ビジネス',
	'3'=>'エンタメ/スポーツ'
);

for ($i = 1901; $i <(date('Y')+1); $i++) {
	$years[$i] = $i;
}

//月プルダウン
$months = array(
    "1" => "1",
    "2" => "2",
	"3" => "3",
    "4" => "4",
	"5" => "5",
    "6" => "6",
	"7" => "7",
    "8" => "8",
	"9" => "9",
	"10" => "10",
	"11" => "11",
	"12" => "12"
);

//日プルダウン
$dates = array(
    "1" => "1",
    "2" => "2",
	"3" => "3",
    "4" => "4",
	"5" => "5",
    "6" => "6",
	"7" => "7",
    "8" => "8",
	"9" => "9",
    "10" => "10",
	"11" => "11",
    "12" => "12",
	"13" => "13",
    "14" => "14",
	"15" => "15",
    "16" => "16",
	"17" => "17",
    "18" => "18",
	"19" => "19",
    "20" => "20",
	"21" => "21",
    "22" => "22",
	"23" => "23",
    "24" => "24",
	"25" => "25",
    "26" => "26",
	"27" => "27",
    "28" => "28",
	"29" => "29",
    "30" => "30",
	"31" => "31"
);

//都道府県プルダウン
$prefs = array(
    "北海道" => "北海道",
    "青森県" => "青森県",
	"岩手県" => "岩手県",
    "宮城県" => "宮城県",
	"秋田県" => "秋田県",
    "山形県" => "山形県",
	"福島県" => "福島県",
    "茨城県" => "茨城県",
	"栃木県" => "栃木県",
    "群馬県" => "群馬県",
	"埼玉県" => "埼玉県",
    "千葉県" => "千葉県",
	"東京都" => "東京都",
    "神奈川県" => "神奈川県",
	"新潟県" => "新潟県",
    "富山県" => "富山県",
	"石川県" => "石川県",
    "福井県" => "福井県",
	"山梨県" => "山梨県",
    "長野県" => "長野県",
	"岐阜県" => "岐阜県",
    "静岡県" => "静岡県",
	"愛知県" => "愛知県",
    "三重県" => "三重県",
	"滋賀県" => "滋賀県",
    "京都府" => "京都府",
	"大阪府" => "大阪府",
    "兵庫県" => "兵庫県",
	"奈良県" => "奈良県",
    "和歌山県" => "和歌山県",
	"鳥取県" => "鳥取県",
	"島根県" => "島根県",
    "岡山県" => "岡山県",
	"広島県" => "広島県",
    "山口県" => "山口県",
	"徳島県" => "徳島県",
    "香川県" => "香川県",
	"愛媛県" => "愛媛県",
    "高知県" => "高知県",
	"福岡県" => "福岡県",
    "佐賀県" => "佐賀県",
	"長崎県" => "長崎県",
    "熊本県" => "熊本県",
	"大分県" => "大分県",
    "宮崎県" => "宮崎県",
	"鹿児島県" => "鹿児島県",
    "沖縄県" => "沖縄県"
);


//都道府県プルダウン
$business_categorys = array(
    "金融・保険" => "金融・保険",
    "ネットサービス" => "ネットサービス",
	"農林水産" => "農林水産",
    "エネルギー・素材・繊維" => "エネルギー・素材・繊維",
	"ファッション・ビューティー" => "ファッション・ビューティー",
    "鉄鋼・非鉄・金属" => "鉄鋼・非鉄・金属",
	"食品関連" => "食品関連",
    "コンピュータ・通信機器" => "コンピュータ・通信機器",
	"自動車・自動車部品" => "自動車・自動車部品",
    "その他製造業" => "その他製造業",
	"商社・流通業" => "商社・流通業",
    "広告・デザイン" => "広告・デザイン",
	"新聞・出版・放送" => "新聞・出版・放送",
    "運輸・交通" => "運輸・交通",
	"医療・健康" => "医療・健康",
    "外食・フードサービス" => "外食・フードサービス",
	"国・自治体・公共機関" => "国・自治体・公共機関",
    "教育" => "教育",
	"旅行・観光・地域情報" => "旅行・観光・地域情報",
    "ビジネス・人事サービス" => "ビジネス・人事サービス",
	"携帯、モバイル関連" => "携帯、モバイル関連",
    "エンタテインメント・音楽関連" => "エンタテインメント・音楽関連",
	"機械" => "機械",
    "精密機器" => "精密機器",
	"不動産" => "不動産",
    "建築" => "建築",
	"その他非製造業" => "その他非製造業",
    "その他サービス" => "その他サービス"
);

//setPulldown関数
function setPulldown($list, $default = "", $format = "%s") {
	$ret = "";
	if(is_array($list)) {
		foreach($list as $key => $val) {
			$ret .= '<option value="'. $val . '"' . ($default == $val ? ' selected' : '') . '>' . sprintf($format, $val) . '</option>';
		}
	}
	return $ret;
}

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function checkfortimepv($time, $flag){
	//1 >> １日ごと
	//2 >> １時間ごと
	//3 >> 30分ごと
	//4 >> 10分ごと
	//5 >> 5分ごと
	//6 >> １分ごと　
	//7 >> １週間ごと
	//8 >> １ヶ月ごと
	if($flag == 1){
		return (strtotime('-1 days') > strtotime($time));
	}
	else if($flag == 2){
		return (strtotime('-1 hours') > strtotime($time));
	}
	else if($flag == 3){
		return (strtotime('-30 minutes') > strtotime($time));
	}
	else if($flag == 4){
		return (strtotime('-10 minutes') > strtotime($time));
	}
	else if($flag == 5){
		return (strtotime('-5 minutes') > strtotime($time));
	}
	else if($flag == 6){
		return (strtotime('-1 minutes') > strtotime($time));
	}
	else if($flag == 7){
		return (strtotime('-1 week') > strtotime($time));
	}
	else if($flag == 8){
		return (strtotime('-1 month') > strtotime($time));
	}
	return false;
}

function timeOpen($time,$otime){
	$timestr = "";
	if($time == 0){
		$timestr = "0分前";
	}
	if($time!="" && $time != 0){
		$daystr = explode(".", $time);
		if($daystr[0]!="0"){
			$timestr = date('m月d日',strtotime($otime));
		}else{
			$hourarr =  explode(".", (("0.".$daystr[1])*24));
			if($hourarr[0]>'0'){
				$timestr = $hourarr[0]."時間前";
			}else{
				$minutearr = explode(".", (("0.".$hourarr[1])*60));
				$timestr = $minutearr[0]."分前";
			}

		}
	}
	return $timestr;
}


function resetBlockSession(){
	unset($_SESSION['current_block']);
	unset($_SESSION['entry_img1']);
	unset($_SESSION['entry_img2']);
	unset($_SESSION['entry_img3']);
	unset($_SESSION['entry_img4']);
	unset($_SESSION['entry_img5']);
	unset($_SESSION['entry_img6']);
	unset($_SESSION['entry_img7']);
	unset($_SESSION['entry_img8']);
}

?>
