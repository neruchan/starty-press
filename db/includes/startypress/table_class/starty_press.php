<?php
class starty_press extends ipfDB1{
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
	
	//記事カテゴリ分類全体数取得
	function selectArticleCategroyCnt($keyword="",$categroy="",$isuser="",$isVideo=""){
		$isvideosql = " AND a.is_video = 0";
		if($isVideo!=""){
			$isvideosql = " AND a.is_video = 1";
		}
		$isusersql = " AND a.userid is null";
		if($isuser!=""){
			$isusersql = " AND a.userid is not null ";
		}
		$categroysql = "";
		if($categroy!=""){
// 			$categroysql = " AND categroy IN($categroy) ";
			$categroysql = " AND categroy LIKE '%$categroy%' ";
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
					$isusersql $categroysql $keywordsql $isvideosql";
		//  		print $sql;
		$data = $this->query($sql);
		return $data[0]["cnt"];
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
	
	//アクセス数変更
	function checkAccesstimeByIP($ipid,$aid){
		$sql = "SELECT * FROM ip_article WHERE ipid = $ipid AND aid = $aid AND delete_flag = 0 ";
		//print $sql;
		$data = $this->query($sql);
		return $data[0];
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
	
	//アクセス数変更
	function checkIp($ipAddress){
		$sql = "SELECT * FROM visitor_ip WHERE ip_address = '$ipAddress' AND delete_flag = 0 ";
		//print $sql;
		$data = $this->query($sql);
		return $data[0];
	}
	
		//記事カテゴリ分類全体情報取得
	function selectArticleCategroyAll($keyword="",$categroy="",$num=20,$page=0,$isuser="",$isVideo="",$idlist=""){
		$isvideosql = " AND a.is_video = 0";
		if($isVideo!=""){
			$isvideosql = " AND a.is_video = 1";
		}
		// $isusersql = " AND a.userid is null";
// 		if($isuser!=""){
// 			$isusersql = " AND a.userid is not null ";
// 		}
		$isusersql = " AND (a.userid is null or a.userid = 0)";
		if($isuser!=""){
			$isusersql = " AND (a.userid is not null and a.userid != 0)";
		}
		$categroysql = "";
		if($categroy!=""){
// 			$categroysql = " AND categroy IN($categroy) ";
			$categroysql = " AND categroy LIKE '%$categroy%' ";
		}
		$keywordsql = "";
		if($keyword!=""){
			$keywordsql = " AND a.title LIKE '%$keyword%' ";
		}
		$idListSql = "";
		if($idlist!=""){
			$idListSql = " AND a.id in ($idlist) ";
		}
		
		$sql = "SELECT
					a.*,
					m.name
				FROM
					article a
				LEFT JOIN model m ON m.model_id = a.entry_name
				WHERE
					a.delete_flag = 0
					$isusersql 
					$categroysql
					$keywordsql
					$isvideosql
					$idListSql
				ORDER BY
					a.addtime DESC
					 LIMIT $num OFFSET ".($page * $num)." ";
// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

}