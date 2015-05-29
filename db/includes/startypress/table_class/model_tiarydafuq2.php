<?php
class model_tiary extends ipfDB1{
	//カワイイキャペンーランキング
	function selectModelDataByID($id){
		if(!$id)
		return array();
		$sql = "SELECT
					m.model_id,
					m.name,
					m.romaji_name,
					m.pic_url_icon,
					m.facebook_url,
					m.twitter_url,
					m.blog_url,
					wr.before_rank
				FROM
					model m
				LEFT JOIN week_model_rank wr ON wr.model_id = m.model_id
				WHERE
					m.model_id = $id AND m.visible_flag<>0 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

	//週間モデルランキング更新時間取得
	function selectModelRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT updatetime FROM week_model_rank WHERE model_id = $id ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["updatetime"];
	}

	//モデルブログ情報取得
	function selectModelBlog(){
		$sql = "SELECT model_id,name,pic_url_icon,facebook_url,twitter_url,blog_url,romaji_name,blog_rss FROM model WHERE visible_flag<>0 ORDER BY blog_time DESC LIMIT 8 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//トップページモデルブログ情報取得
	function selectModelBlogTop($type=1){
		$sql = "SELECT * FROM model WHERE visible_flag=$type ORDER BY blog_time DESC ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//ブログページモデル全体数取得
	function selectModelBlogCnt(){
		$sql = "SELECT count(*)cnt FROM model WHERE visible_flag<>0 ORDER BY model_id ASC ";
		//  		print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//ブログページモデル全体情報取得
	function selectModelBlogAll($num=20,$page=0){
		$sql = "SELECT model_id,name,romaji_name,pic_url_icon,facebook_url,twitter_url,blog_url,blog_rss FROM model WHERE visible_flag<>0 ORDER BY blog_time DESC LIMIT $num OFFSET ".($page * $num)." ";
	// 		print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//Ｒｓｓ情報存在チェック
	function checkRssLink($link){
		if(!$link)
		return array();
		$sql = "SELECT count(*)cnt FROM article WHERE links ='$link' AND delete_flag = 0 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//記事新着情報取得
	function selectArticleNew($num=10){
		$sql = "SELECT
					title,
					id,
					addtime
				FROM
					article
				WHERE
					delete_flag = 0
				AND addtime > date_sub(now(), INTERVAL 1 DAY)
				ORDER BY
					addtime DESC LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//記事ランキング
	function selectArticleRank($num=5){
		$sql = "SELECT
					a.id,
					a.categroy,
					a.title,
					a.addtime,
					a.access_num,
					ar.before_rank,
					a.image,
					a.contents
				FROM
					article a
				LEFT JOIN article_rank ar ON ar.article_id = a.id
				WHERE
					a.delete_flag = 0
				ORDER BY
					a.access_num DESC
				LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//記事ランキングＩＤ取得
	function selectArticleRankID(){
		$sql = "SELECT id FROM article WHERE delete_flag = 0 ORDER BY access_num DESC ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//記事ランキング前回情報存在チェック
	function checkArticleRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT count(*)cnt FROM article_rank WHERE article_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//記事新着情報取得
	function selectRightArticleNew($num=10){
		$sql = "SELECT
						title,
						id,
						addtime,
						image,
						contents

					FROM
						article
					WHERE
						delete_flag = 0
					ORDER BY
						addtime DESC LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//記事カテゴリ分類全体数取得
	function selectArticleCategroyCnt($keyword="",$categroy=""){
		$categroysql = "";
		if($categroy!=""){
			$categroysql = " AND categroy IN($categroy) ";
		}
		$keywordsql = "";
		if($keyword!=""){
			$keywordsql = " AND a.title LIKE '%$keyword%' ";
		}
		$sql = "SELECT
					count(*)cnt
				FROM
					article a
				LEFT JOIN model m ON m.model_id = a.entry_name
				WHERE
					a.delete_flag = 0
					$categroysql $keywordsql ";
		//  		print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//記事カテゴリ分類全体情報取得
	function selectArticleCategroyAll($keyword="",$categroy="",$num=20,$page=0){
		$categroysql = "";
		if($categroy!=""){
			$categroysql = " AND categroy IN($categroy) ";
		}
		$keywordsql = "";
		if($keyword!=""){
			$keywordsql = " AND a.title LIKE '%$keyword%' ";
		}
		$sql = "SELECT
					a.id,
					a.title,
					a.categroy,
					a.entry_name,
					a.image,
					a.addtime,
					a.contents,
					m.name
				FROM
					article a
				LEFT JOIN model m ON m.model_id = a.entry_name
				WHERE
					a.delete_flag = 0
					$categroysql
					$keywordsql
				ORDER BY
					a.addtime DESC
					 LIMIT $num OFFSET ".($page * $num)." ";
// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//記事詳細情報取得
	function selectArticleByID($id){
		if(!$id)
		return array();
		$sql = "SELECT a.*,m.name FROM article a LEFT JOIN model m ON m.model_id = a.entry_name WHERE a.id=$id AND a.delete_flag=0 ";
		//print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

	//関連記事情報取得
	function selectConnectionArticle($categroy){
		if(!$categroy)
		return array();
		$sql = "SELECT
								title,
								id,
								addtime
							FROM
								article
							WHERE
								delete_flag = 0
								 AND categroy IN($categroy)
							ORDER BY
								addtime DESC LIMIT 8 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//アクセス数変更
	function selectUpdateAccessByID($id){
		if(!$id)
		return array();
		$sql = "UPDATE article SET access_num = access_num+1 WHERE id = $id ";
		//print $sql;
		$data = $this->query($sql,1);
		return $data;
	}

	//モデル個人情報取得
	function selectModelByID($id){
		if(!$id)
		return array();
		$sql = "SELECT * FROM model WHERE model_id = $id AND visible_flag<>0 ";
// 		print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

	//tiary投稿者カワイイランキングチェック
	function checkEntryerRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT updatetime FROM tiary_entryer_rank WHERE user_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["updatetime"];
	}

	//tiary投稿者カワイイランキング番号
	function selectEntryerRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT before_rank FROM tiary_entryer_rank WHERE user_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["before_rank"];
	}

	//tiaryカワイイランキングチェック
	function checkKawaiiRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT updatetime FROM tiary_kawaii_rank WHERE entry_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["updatetime"];
	}

	//tiaryカワイイランキング番号
	function selectKawaiiRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT before_rank FROM tiary_kawaii_rank WHERE entry_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["before_rank"];
	}


	//店舗ランキングチェック
	function checkShopRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT updatetime FROM tiary_shop_rank WHERE shop_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["updatetime"];
	}

	//店舗カワイイランキング番号
	function selectShopRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT before_rank FROM tiary_shop_rank WHERE shop_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["before_rank"];
	}

	//新着記事情報取得
	function selectArticleNewTop($num=5){
		$sql = "SELECT
						a.id,
						a.title,
						a.categroy,
						a.entry_name,
						a.image,
						a.addtime,
						a.contents,
						m.name
					FROM
						article a
					LEFT JOIN model m ON m.model_id = a.entry_name
					WHERE
						a.delete_flag = 0
					ORDER BY
						a.addtime DESC
						 LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//オーディショントップ
	function selectAuditionTop(){
		$sql = "SELECT audition_title,audition_url,audition_new_flag FROM audition WHERE delete_flag = 0 ORDER BY addtime DESC LIMIT 10 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}


	//オーディション全体数取得
	function selectAuditionCnt(){

	$sql = "SELECT
					count(*)cnt
				FROM
					audition
				WHERE
					delete_flag = 0";
	//  		print $sql;
	$data = $this->query($sql);
	return $data[0]["cnt"];
	}

	//オーディション全体情報取得
	function selectAuditionAll($num=20,$page=0){
		$sql = "SELECT
					audition_title,
					audition_url,
					audition_new_flag,
					audition_text,
					end_time
				FROM
					audition
				WHERE
					delete_flag = 0
				ORDER BY
					addtime DESC
					LIMIT $num OFFSET ".($page * $num)." ";
	// 				print $sql;
			$data = $this->query($sql);
			return $data;
	}

	//ライター全体数取得
	function selectWriterCnt(){

		$sql = "SELECT
					count(*)cnt
				FROM
					writer w
				LEFT JOIN(
					SELECT
						count(writer_id)access_num,
						writer_id
					FROM
						article
					GROUP BY
						writer_id
				) a ON a.writer_id = w.id
				WHERE
					w.delete_flag = 0";
		//  		print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//ライター全体情報取得
	function selectWriterAll($num=20,$page=0){
		$sql = "SELECT
					w.id,
					w.roma_name,
					w.image,
					w.fb_url,
					w.blog_url,
					w.tw_url,
					w.introduce,
					IFNULL(a.access_num,0) access
				FROM
					writer w
				LEFT JOIN(
					SELECT
						count(writer_id)access_num,
						writer_id
					FROM
						article
					GROUP BY
						writer_id
				) a ON a.writer_id = w.id
				WHERE
					w.delete_flag = 0
				ORDER BY
					w.addtime DESC
				LIMIT $num OFFSET ".($page * $num)." ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//ライター情報取得
	function selectWriterRankdata($num=15){
		$sql = "SELECT
						w.id
					FROM
						writer w
					LEFT JOIN(
						SELECT
							count(writer_id)access_num,
							writer_id
						FROM
							article
						GROUP BY
							writer_id
					)a ON a.writer_id = w.id
					WHERE
						w.delete_flag = 0
					ORDER BY
						IFNULL(a.access_num, 0) DESC
				LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//ライターランキングチェック
	function checkWriterRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT updatetime FROM writer_rank WHERE writer_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["updatetime"];
	}

	//記事ランキング
	function selectWriterRank($num=5){
		$sql = "SELECT
						w.id,
						w.name,
						w.roma_name,
						w.image,
						w.fb_url,
						w.blog_url,
						w.tw_url,
						w.introduce,
						IFNULL(a.access_num, 0)access,
						wr.before_rank
					FROM
						writer w
					LEFT JOIN(
						SELECT
							count(writer_id)access_num,
							writer_id
						FROM
							article
						GROUP BY
							writer_id
					)a ON a.writer_id = w.id
					LEFT JOIN writer_rank wr ON wr.writer_id = w.id
					WHERE
						w.delete_flag = 0
					ORDER BY
						IFNULL(a.access_num, 0) DESC
					LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//バナー
	function selectBannelData(){
		$sql = "SELECT * FROM banner_advertising WHERE delete_flag = 0 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//店舗情報取得
	function selectModelShopRankdata($num=15){
		$sql = "SELECT id,ranking FROM shop WHERE delete_flag = 0 ORDER BY ranking ASC LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//店舗ランキングチェック
	function checkModelShopRankByID($id){
		if(!$id)
		return array();
		$sql = "SELECT updatetime FROM shop_rank WHERE shop_id=$id  ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["updatetime"];
	}

	//店舗ランキング
	function selectModelShopRank($num=5){
		$sql = "SELECT
					s.*, sk.before_rank
				FROM
					shop s
				LEFT JOIN shop_rank sk ON sk.shop_id = s.id
				WHERE
					s.delete_flag = 0
				ORDER BY
					s.ranking ASC LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//広告新着記事情報取得
	function selectArticleNewPayToppage($num=2){
		$sql = "SELECT
								id,
								title,
								categroy,
								entry_name,
								image,
								addtime,
								contents
							FROM
								article
							WHERE
								delete_flag = 0 AND pay_flag = 1 AND DATE_ADD(addtime, INTERVAL 7 DAY) > NOW()
							ORDER BY
								addtime DESC
								 LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//今月広告新着記事情報取得
	function selectArticleNewPayMonthToppage($num=6){
		$sql = "SELECT
									id,
									title,
									categroy,
									entry_name,
									image,
									addtime,
									contents
								FROM
									article
								WHERE
									delete_flag = 0 AND pay_flag = 1 AND DATE_ADD(addtime, INTERVAL 7 DAY) < NOW() AND DATE_ADD(addtime, INTERVAL 37 DAY) > NOW()
								ORDER BY
									addtime DESC
									 LIMIT $num ";
// 		print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//新着記事情報取得
	function selectArticleNewToppage($num=6){
		$sql = "SELECT
							id,
							title,
							categroy,
							entry_name,
							image,
							addtime,
							contents
						FROM
							article
						WHERE
							delete_flag = 0 AND pay_flag = 0
						ORDER BY
							addtime DESC
							 LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//モデルブログ情報取得
	function selectModelBlogRss(){
		$sql = "SELECT model_id,blog_rss FROM model WHERE visible_flag<>0 ORDER BY model_id ASC ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	function updateModelBlogTime($id,$date){
		if(!$id)
		return array();
		$sql = "UPDATE model SET blog_time = '$date' WHERE model_id = $id ";
		// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}

	//バナーチェック
	function checkBanner($bid){
		if(!$bid)
		return array();
		$sql = "SELECT ba_url FROM banner_advertising WHERE id=$bid AND delete_flag=0 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["ba_url"];
	}

	//バナーチェック
	function addBannerClickNum($bid){
		if(!$bid)
		return array();
// 		$sql = "UPDATE banner_advertising SET click_num =click_num+1  WHERE id = $bid ";
		$sql = "INSERT INTO banner_click (banner_id,addtime) VALUES ($bid,now()) ";
		// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}

	//ヘッダバナー
	function selectHeadBanner(){
		$sql = "SELECT
					id,
					ba_image
				FROM
					banner_advertising
				WHERE
					delete_flag = 0
				AND ba_start <= CURDATE()
				AND ba_end >= CURDATE()
				AND part_flag = 3
				ORDER BY
					RAND()
				LIMIT 1 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//左バナー
	function selectLeftBanner(){
		$sql = "SELECT
						id,
						ba_image
					FROM
						banner_advertising
					WHERE
						delete_flag = 0
					AND ba_start <= CURDATE()
					AND ba_end >= CURDATE()
					AND part_flag = 4
					ORDER BY
						RAND()
					LIMIT 2 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//左バナー
	function selectLeftBanner2($year,$month){
		$sql = "SELECT
					id,
					ba_image
				FROM
					banner_advertising
				WHERE
					delete_flag = 0
				AND part_flag = 6
				AND(
					(
						EXTRACT(YEAR FROM ba_start)= $year
						AND EXTRACT(MONTH FROM ba_start)= $month
					)
					OR(
						EXTRACT(YEAR FROM ba_end)= $year
						AND EXTRACT(MONTH FROM ba_end)= $month
					)
				)
				ORDER BY
					RAND()
				LIMIT 5 ";
// 		print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//アドコードチェック
	function checkClient($id){
		if(!$id)
		return array();
		$sql = "SELECT client_url FROM article WHERE id=$id AND delete_flag=0";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["client_url"];
	}

	//アドコードチェック
	function addClientClickNum($id){
		if(!$id)
		return array();
		// 		$sql = "UPDATE banner_advertising SET click_num =click_num+1  WHERE id = $bid ";
		$sql = "INSERT INTO client_click (article_id,addtime) VALUES ($id,now()) ";
		// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}
	
	
	////////////////////////////////////////////////////////////////////////////////////////////
	// NELSON
	//追加投稿機能
	
	//アクセス数変更
	function checkIp($ipAddress){
		$sql = "SELECT * FROM visitor_ip WHERE ip_address = '$ipAddress' AND delete_flag = 0 ";
		//print $sql;
		$data = $this->query($sql);
		return $data[0];
	}
	
	//アクセス数変更
	function checkAccesstimeByIP($ipid,$aid){
		$sql = "SELECT * FROM ip_article WHERE ipid = $ipid AND aid = $aid AND delete_flag = 0 ";
		//print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

}