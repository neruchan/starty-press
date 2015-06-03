var sliding=false; // スライド中フラグ

$(function() {
	// スライドタイマー処理開始
	timer=setInterval("showcaseMoveNext()",3500);
	
	// nextボタンクリック
	$("#showcase_prev").click(function(){
	  showcaseMovePrev();
	});
	
	// prevボタンクリック
	$("#showcase_next").click(function(){
	  showcaseMoveNext();
	});
});

// next処理
function showcaseMoveNext(){
	if(sliding)return;
	sliding=true;
	var imageWidth = $('#showcase_list li:first').width();
	$("#showcase_list").animate({marginLeft: "-="+imageWidth+"px"},{
		queue: true,
		duration: "slow",
		complete: function(){		
			c = $('#showcase_list li:first').clone();
			addFadeHover(c);
			$('#showcase_list li:first').remove();
			$("#showcase_list").css("margin-left","0px");
			$("#showcase_list").append(c);
			sliding=false;
		}
	});
}

// prev処理
function showcaseMovePrev(){
	if(sliding)return;
	sliding=true;
	var imageWidth = $('#showcase_list li:last').width();
	$("#showcase_list").animate({marginLeft: "+="+imageWidth+"px"},{
		queue: true,
		duration: "slow",
		complete: function(){		
			c = $('#showcase_list li:last').clone();
			addFadeHover(c);
			$("#showcase_list").prepend(c);
			$('#showcase_list li:last').remove();
			$("#showcase_list").css("margin-left","0px");
			sliding=false;
		}
	});
}

// 画像マウスアクション追加
function addFadeHover(obj){
	obj.hover(function(){
		$(this).stop().fadeTo(50, 0.8);
	},function(){
		$(this).fadeTo(300, 1);
	});
}

