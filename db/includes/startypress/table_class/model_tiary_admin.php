<?php
class model_tiary_admin extends ipfDB1{
	function CheckPassword($name,$pass){
		if(!$name)
		return array();

		$sql = "SELECT count(*)cnt FROM admin WHERE username='$name' AND password='$pass' AND type=3; ";
		//     	print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//全記事数取得
	function selectArticleAllNum($isuser="",$isvideo=""){
		$isvideosql = " AND is_video = 0";
		if($isvideo!=""){
			$isvideosql = " AND is_video = 1 ";
		}
		
		$isusersql = " AND userid is null";
		if($isuser!=""){
			$isusersql = " AND userid is not null ";
		}
		
		$sql = "SELECT
						count(*)cnt
					FROM
					article
				WHERE
					delete_flag = 0
					$isusersql
					$isvideosql
					";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}
	
	//記事登録数取得
	function selectArticleCntAll($category=0,$writer=0,$addtime=0,$isuser="",$isvideo="",$isGaibu=""){
		$isvideosql = " AND is_video = 0";
		if($isvideo!=""){
			$isvideosql = " AND is_video = 1 ";
		}
		
		$isusersql = " AND userid is null";
		if($isuser!=""){
			$isusersql = " AND userid is not null ";
		}
		$categorysql = "";
		if($category!="" && $category!="0"){
			$categorysql = " AND categroy IN($category) ";
		}
		$writersql = "";
		if($writer==1){
			$writersql = " AND writer_id <> 0 ";
		}elseif($writer==2){
			$writersql = " AND writer_id = 0 ";
		}
		
		$gaibusql = "";
		if($isGaibu==1){
			$gaibusql = " AND is_outsource = 0 ";
		}elseif($isGaibu==2){
			$gaibusql = " AND is_outsource = 1 ";
		}

		$addtimesql = "";
		if($addtime==1){
			$addtimesql = " ORDER BY addtime DESC ";
		}elseif($addtime==2){
			$addtimesql = " ORDER BY addtime ASC ";
		}else{
			$addtimesql = " ORDER BY id ASC ";
		}

		$sql = "SELECT
					count(*)cnt
				FROM
					article
				WHERE
					delete_flag = 0
					$isusersql
					$isvideosql
					$categorysql
					$writersql
					$gaibusql
					$addtimesql ";
// 		print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//全体記事情報取得
	function selectArticleAll($category=0,$writer=0,$addtime=0,$num=20,$page=0,$isuser="",$isvideo="",$isGaibu="",$pv=0){
		$isvideosql = " AND is_video = 0";
		if($isvideo!=""){
			$isvideosql = " AND is_video = 1 ";
		}
		$isusersql = " AND userid is null";
		if($isuser!=""){
			$isusersql = " AND userid is not null ";
		}
		$categorysql = "";
		if($category!="" && $category!="0"){
			$categorysql = " AND categroy IN($category) ";
		}
		$writersql = "";
		if($writer==1){
			$writersql = " AND writer_id <> 0 ";
		}elseif($writer==2){
			$writersql = " AND writer_id = 0 ";
		}
		
		$gaibusql = "";
		if($isGaibu==1){
			$gaibusql = " AND is_outsource = 0 ";
		}elseif($isGaibu==2){
			$gaibusql = " AND is_outsource = 1 ";
		}
		
		$sortsql = "ORDER BY id DESC";
		if($addtime==1){
			$sortsql = " ORDER BY addtime DESC ";
		}elseif($addtime==2){
			$sortsql = " ORDER BY addtime ASC ";
		}
		

		if($pv==1){
			$sortsql = " ORDER BY access_num DESC ";
		}elseif($pv==2){
			$sortsql = " ORDER BY access_num ASC ";
		}
		$sql = "SELECT
					*
				FROM
					article
				WHERE
					delete_flag = 0
					$isusersql
					$isvideosql
					$categorysql
					$writersql
					$gaibusql
					$sortsql
					LIMIT $num OFFSET ".($page * $num)."";
// 						print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//ライターリスト取得
	function selectWriterData(){
		$sql = "SELECT id,name FROM writer WHERE delete_flag = 0 ORDER BY name ASC ";
		// 		print $sql;
		$data = $this->query($sql);
		return $data;
	}
	
	function selectTagExists($tagName){
    	if(!$tagName)
            return array();

        $sql = "SELECT id FROM article_tag WHERE name = '$tagName'";

        //print $sql;
        $data = $this->query($sql);
        return $data[0]['id'];
    	
    }
    
    function selectTagDetailById($tid){
    	if(!$tid)
            return array();

        $sql = "SELECT * FROM article_tag WHERE id = $tid";

        //print $sql;
        $data = $this->query($sql);
        return $data[0];
    	
    }


	//記事削除
	function deleteArticle($id){
		if(!$id)
		return array();
		$idarr = explode(",", $id);
		$sqlstr = "(";
		foreach ($idarr as $key=>$val){
			if($key>0)$or = " OR ";
			$sqlstr .=" $or id= $val ";
		}
		$sqlstr .= ") ";
		$sql = "UPDATE article SET delete_flag = 1 WHERE $sqlstr ";
// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}

	//記事情報取得
	function selectArticleByID($id){
		if(!$id)
		return array();
		$sql = "SELECT a.*,w.name FROM article a LEFT JOIN writer w ON w.id = a.writer_id WHERE a.delete_flag = 0 AND a.id = $id ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

	//全ライター数取得
	function selectWriterAllNum(){
		$sql = "SELECT count(*)cnt FROM writer WHERE delete_flag = 0 ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}
	//ライター登録数取得
	function selectWriterCntAll($access=0){
		$sql = "SELECT count(*)cnt FROM writer WHERE delete_flag = 0 ";
// 		print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//全体ライター情報取得
	function selectWriterAll($access=0,$num=20,$page=0){
		$accesssql = "";
		if($access==1){
			$accesssql = " ORDER BY access_num DESC ";
		}elseif($access==2){
			$accesssql = " ORDER BY access_num ASC ";
		}else{
			$accesssql = " ORDER BY w.id ASC ";
		}
		$sql = "SELECT
					w.id,
					w.name,
					w.roma_name,
					w.image,
					w.blog_url,
					IFNULL(t1.access_num, 0)access_num
				FROM
					writer w
				LEFT JOIN(
					SELECT
						count(a.writer_id)access_num,
						a.writer_id
					FROM
						article a
					WHERE
						a.delete_flag = 0
					GROUP BY
						a.writer_id
				)t1 ON t1.writer_id = w.id
				WHERE
					w.delete_flag = 0
					$accesssql
					LIMIT $num OFFSET ".($page * $num)."";
// 						print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//投稿削除
	function deleteWriter($wid){
		if(!$wid)
		return array();
		$useridarr = explode(",", $wid);
		$sqlstr = "(";
		foreach ($useridarr as $key=>$val){
			if($key>0)$or = " OR ";
			$sqlstr .=" $or id= $val ";
		}
		$sqlstr .= ") ";
		$sql = "UPDATE writer SET delete_flag = 1 WHERE $sqlstr ";
		// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}

	//投稿情報取得
	function selectWriterByID($id){
		if(!$id)
		return array();
		$sql = "SELECT
					w.id,
					w.name,
					w.roma_name,
					w.image,
					w.blog_url,
					w.fb_url,
					w.tw_url,
					w.introduce,
					IFNULL(t1.access_num, 0)access_num
				FROM
					writer w
				LEFT JOIN(
					SELECT
						count(a.writer_id)access_num,
						a.writer_id
					FROM
						article a
					WHERE
						a.delete_flag = 0
					GROUP BY
						a.writer_id
				)t1 ON t1.writer_id = w.id
				WHERE
					w.delete_flag = 0 AND w.id=$id ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

	//オーディション数取得
	function selectAuditionAllNum(){
		$sql = "SELECT count(*)cnt FROM audition WHERE delete_flag = 0 ";
		// 						print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//全体オーディション数取得(条件あり)
	function selectAuditionCntAll($addtime=0){
		$addtimesql = "";
		if($addtime==1){
			$addtimesql = " ORDER BY addtime DESC ";
		}elseif($addtime==2){
			$addtimesql = " ORDER BY addtime ASC ";
		}else{
			$addtimesql = " ORDER BY id ASC ";
		}

		$sql = "SELECT count(*)cnt FROM audition WHERE delete_flag = 0 ";
		// 						print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//全体オーディション情報取得
	function selectAuditionAll($addtime=0,$num=20,$page=0){
		$addtimesql = "";
		if($addtime==1){
			$addtimesql = " ORDER BY addtime DESC ";
		}elseif($addtime==2){
			$addtimesql = " ORDER BY addtime ASC ";
		}else{
			$addtimesql = " ORDER BY id ASC ";
		}
		$sql ="SELECT
					id,
					audition_title,
					audition_url,
					addtime,
					end_time
				FROM
					audition
				WHERE
					delete_flag = 0
					$addtimesql
					LIMIT $num OFFSET ".($page * $num)." ";
// 			print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//オーディション取得
	function selectAuditionByID($aid){
		if(!$aid)
		return array();
		$sql = "SELECT
					id,
					audition_title,
					audition_url,
					addtime,
					end_time,
					audition_text,
					audition_new_flag
				FROM
					audition
				WHERE
					delete_flag = 0 AND id = $aid ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

	//オーディション削除
	function deleteAudition($aid){
		if(!$aid)
		return array();
		$useridarr = explode(",", $aid);
		$sqlstr = "(";
		foreach ($useridarr as $key=>$val){
			if($key>0)$or = " OR ";
			$sqlstr .=" $or id= $val ";
		}
		$sqlstr .= ") ";
		$sql = "UPDATE audition SET delete_flag = 1 WHERE $sqlstr ";
		// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}

	//バナー情報取得
	function selectBannerByID($id){
		if(!$id)
		return array();
		$sql = "SELECT ba_url,ba_image FROM banner_advertising WHERE delete_flag = 0 AND id = $id ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

	//バナー削除
	function deleteBanner($id){
		if(!$id)
		return array();
		$useridarr = explode(",", $id);
		$sqlstr = "(";
		foreach ($useridarr as $key=>$val){
			if($key>0)$or = " OR ";
			$sqlstr .=" $or id= $val ";
		}
		$sqlstr .= ") ";
		$sql = "UPDATE banner_advertising SET delete_flag = 1 WHERE $sqlstr ";
		// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}


	//ランキング数取得
	function selectRankingAllNum(){
		$sql = "SELECT count(*)cnt FROM shop WHERE delete_flag = 0 ";
		// 						print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//全体ランキング数取得(条件あり)
	function selectRankingCntAll($category=0,$rank_num=0){
		$categorysql = "";
		if($category!="" && $category!="0"){
			$categorysql = " AND shop_category IN($category) ";
		}

		$rank_numsql = "";
		if($rank_num==1){
			$rank_numsql = " ORDER BY access_num DESC ";
		}elseif($rank_num==2){
			$rank_numsql = " ORDER BY access_num ASC ";
		}else{
			$rank_numsql = " ORDER BY ranking ASC ";
		}

		$sql = "SELECT count(*)cnt FROM shop WHERE delete_flag = 0 $categorysql ";
		// 						print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//全体ランキング情報取得
	function selectRankingAll($category=0,$rank_num=0,$num=20,$page=0){
		$categorysql = "";
		if($category!="" && $category!="0"){
			$categorysql = " AND shop_category IN($category) ";
		}

		$rank_numsql = "";
		if($rank_num==1){
			$rank_numsql = " ORDER BY access_num DESC ";
		}elseif($rank_num==2){
			$rank_numsql = " ORDER BY access_num ASC ";
		}else{
			$rank_numsql = " ORDER BY ranking ASC ";
		}
		$sql ="SELECT
						id,
						shop_name,
						shop_image,
						shop_category,
						access_num,
						ranking
					FROM
						shop
					WHERE
						delete_flag = 0
						$categorysql
						$rank_numsql
						LIMIT $num OFFSET ".($page * $num)." ";
		// 			print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//ランキング取得
	function selectRankingByID($sid){
		if(!$sid)
		return array();
		$sql = "SELECT
						id,
						shop_name,
						ranking,
						shop_category,
						access_num,
						shop_image
					FROM
						shop
					WHERE
						delete_flag = 0 AND id = $sid ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}

	//オーディション削除
	function deleteRanking($sid){
		if(!$sid)
		return array();
		$useridarr = explode(",", $sid);
		$sqlstr = "(";
		foreach ($useridarr as $key=>$val){
			if($key>0)$or = " OR ";
			$sqlstr .=" $or id= $val ";
		}
		$sqlstr .= ") ";
		$sql = "UPDATE shop SET delete_flag = 1 WHERE $sqlstr ";
		// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}

	//アドコードのクリック数取得
	function selectClientClickNum($id){
		if(!$id)
		return array();
		$sql = "SELECT count(*)cnt FROM client_click WHERE article_id=$id ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}
	
	
	
	//全ユーザー数取得
	function selectUserAllNum(){
		$sql = "SELECT
						count(*)cnt
					FROM
						users u
					JOIN users_info ui ON ui.userid = u.id
					WHERE
						u.delete_flag = 0
					";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}
	//ユーザー管理ユーザー登録数取得
	function selectUserCntAll($id,$username,$pv_flag=0){
		$keywordsql = "";
		if($id!=""){
			$keywordsql .= " AND u.id = '$id' ";
		}

		if($username!=""){
			$keywordsql .= " AND ui.nickname LIKE '%$username%' ";
		}
		
		$orderSql = " ORDER BY id ASC";
		$pv_sql = "";
		if($pv_flag == 3){
			$pv_sql = " HAVING SUM(aj.access_num) >= 50000 ";
		}
		else if($pv_flag == 4){
			$pv_sql = " HAVING SUM(aj.access_num) < 50000 ";
		}

		$sql = "
				SELECT
					count(*)cnt
				FROM
					users u
				JOIN users_info ui ON ui.userid = u.id
				LEFT JOIN(
					SELECT id,userid,access_num 
					FROM article
					WHERE delete_flag=0 AND userid is NOT null
				)aj ON aj.userid = u.id
				WHERE
					u.delete_flag = 0
					$keywordsql
				GROUP BY u.id
				$pv_sql
				";
		// 				print $sql;
		$data = $this->query($sql);
		return count($data);
	}

	//全体ユーザー情報取得
	function selectUserAll($id,$username,$pv_flag=0,$article_num=0,$num=20,$page=0){
		$keywordsql = "";
		if($id!=""){
			$keywordsql .= " AND u.id = '$id' ";
		}

		if($username!=""){
			$keywordsql .= " AND ui.nickname LIKE '%$username%' ";
		}
		
		$orderSql = " ORDER BY id ASC";
		$pv_sql = "";
		if($pv_flag == 1){
			$orderSql = " ORDER BY num_pv DESC ";
		}
		else if($pv_flag == 2){
			$orderSql = " ORDER BY num_pv ASC ";
		}
		else if($pv_flag == 3){
			$pv_sql = " HAVING num_pv >= 50000 ";
		}
		else if($pv_flag == 4){
			$pv_sql = " HAVING num_pv < 50000 ";
		}
		
		if($article_num == 1){
			$orderSql = " ORDER BY num_article DESC ";
		}
		else if($article_num == 2){
			$orderSql = " ORDER BY num_article ASC ";
		}
		
		$sql = "
				SELECT
					u.id,
					ui.nickname,
					ui.username,
					ui.birthday,
					u.created,
					u.terminal,
					u.cmflag,
					SUM(aj.access_num)num_pv,
					COUNT(aj.id)num_article
				FROM
					users u
				JOIN users_info ui ON ui.userid = u.id
				LEFT JOIN(
					SELECT id,userid,IFNULL(access_num , 0)access_num
					FROM article
					WHERE delete_flag=0 AND userid is NOT null
				)aj ON aj.userid = u.id
				WHERE
					u.delete_flag = 0
					$keywordsql
				GROUP BY u.id
				$pv_sql
				$orderSql
				LIMIT $num OFFSET ".($page * $num)."";
 						//print $sql;
		$data = $this->query($sql);
		return $data;
	}
	
	//記事削除
	function deleteUser($id){
		if(!$id)
		return array();
		$idarr = explode(",", $id);
		$sqlstr = "(";
		foreach ($idarr as $key=>$val){
			if($key>0)$or = " OR ";
			$sqlstr .=" $or id= $val ";
		}
		$sqlstr .= ") ";
		$sql = "UPDATE users SET delete_flag = 1 WHERE $sqlstr ";
// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}
	
	
	//ユーザー情報取得
	function selectUserDataByID($userid){
		if(!$userid)
		return array();
		$sql = "SELECT
							u.id,
							ui.nickname,
							ui.username,
							ui.birthday,
							u.created,
							u.terminal,
							u.email,
							u.cmflag,
							ui.fullname,
							ui.fullname_kana,
							ui.banti,
							ui.todoufuken,
							ui.phonenumber,
							ui.zipcode,
							ui.model_type,
							ui.model_id
						FROM
							users u
						JOIN users_info ui ON ui.userid = u.id
						WHERE
							u.delete_flag = 0 AND
							u.id=$userid
							";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}
	
	//全ユーザー数取得
	function selectKeywordAllNum(){
		$sql = "SELECT
						count(*)cnt
					FROM
						search_keyword_display kd
					WHERE
						kd.delete_flag = 0
					";
		 			//	print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}
	
	
	//全体ユーザー情報取得
	function selectKeywordAll($addtime,$num=20,$page=0){
		$addtimesql = "";
		if($addtime==1){
			$addtimesql = " ORDER BY addtime DESC ";
		}elseif($addtime==2){
			$addtimesql = " ORDER BY addtime ASC ";
		}else{
			$addtimesql = " ORDER BY id ASC ";
		}
		
		$sql = "
				SELECT
					kd.*
				FROM
					search_keyword_display kd
				WHERE
					kd.delete_flag = 0
				$addtimesql
				LIMIT $num OFFSET ".($page * $num)."";
 				//		print $sql;
		$data = $this->query($sql);
		return $data;
	}
	
	//記事削除
	function deleteKeyword($id){
		if(!$id)
		return array();
		$idarr = explode(",", $id);
		$sqlstr = "(";
		foreach ($idarr as $key=>$val){
			if($key>0)$or = " OR ";
			$sqlstr .=" $or id= $val ";
		}
		$sqlstr .= ") ";
		$sql = "UPDATE search_keyword_display SET delete_flag = 1 WHERE $sqlstr ";
// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}
	
	//記事情報取得
	function selectKeywordByID($id){
		if(!$id)
		return array();
		$sql = "SELECT kw.* FROM search_keyword_display kw WHERE kw.delete_flag = 0 AND kw.id = $id";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}
	
	
	
	//全ユーザー数取得
	function selectAllSearchedKeywordNum(){
		$sql = "SELECT
						count(*)cnt
					FROM
						search_keyword sk
					WHERE
						sk.delete_flag = 0
					";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
	}

	//全体ユーザー情報取得
	function selectSearchedKeyword($addtime=0,$searched_flag=0,$num=20,$page=0){
		$sortSql = "";
		
		if($addtime==1){
			$sortSql = " ORDER BY addtime DESC ";
		}elseif($addtime==2){
			$sortSql = " ORDER BY addtime ASC ";
		}else{
			$sortSql = " ORDER BY id ASC ";
		}
		
		if($searched_flag == 1){
			$sortSql = " ORDER BY access_number DESC ";
		}
		else if($searched_flag == 2){
			$sortSql = " ORDER BY access_number ASC ";
		}
		
		$sql = "
				SELECT
					kw.*
				FROM
					search_keyword kw
				WHERE
					kw.delete_flag = 0
				$sortSql
				LIMIT $num OFFSET ".($page * $num)."";
 						//print $sql;
		$data = $this->query($sql);
		return $data;
	}
	
	//記事削除
	function deleteSearchedKeyword($id){
		if(!$id)
		return array();
		$idarr = explode(",", $id);
		$sqlstr = "(";
		foreach ($idarr as $key=>$val){
			if($key>0)$or = " OR ";
			$sqlstr .=" $or id= $val ";
		}
		$sqlstr .= ") ";
		$sql = "UPDATE search_keyword SET delete_flag = 1 WHERE $sqlstr ";
// 				print $sql;
		$data = $this->query($sql,1);
		return $data;
	}
	
	//記事削除
	function deleteAllTagByArticleId($aid){
		if(!$aid)
		return array();
		
		
		$sql = "DELETE FROM article_c_tag where article_id = $aid ";
// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}
	
	function selectTagsByArticleId($aid){

        $sql = "SELECT a.id,a.title,a.contents,c.id,c.name 
        		FROM article a 
        		LEFT JOIN article_c_tag b ON a.id = b.article_id 
        		LEFT JOIN article_tag c ON b.tag_id = c.id 
        		where a.id = $aid and c.name is not null";

        //print $sql;
        $data = $this->query($sql);
        return $data;
    }
    
    function selectTopBlockByArticleId($article_id){
		if(!$article_id)
		return array();
		$sql = "SELECT
					ab.*
				FROM
					article_block ab
				WHERE
					ab.article_id = $article_id AND delete_flag = 0 ORDER BY ab.order_block ASC";
		// 				print $sql;
		$data = $this->query($sql);
		return $data[0];
	}
	
	function selectRSSSettings(){

        $sql = "SELECT *
        		FROM rss_yahoo_settings";

        //print $sql;
        $data = $this->query($sql);
        return $data;
    }
}
?>