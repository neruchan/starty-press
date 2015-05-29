<?php
class entry_tiary extends ipfDB1{
	//カワイイキャペンーランキング
	function selectCampRankdata($num=5){
		// 		if(!$eid)
		// 		return array();
		$sql = "SELECT
					ui.model_id,
					ui.userid,
					IFNULL(c.charmnum,0) charmnum
				FROM
					users u
				JOIN users_info ui ON ui.userid = u.id
				LEFT JOIN(
					SELECT
						count(cm.c_sc_id)charmnum,
						sc.sc_userid
					FROM
						charmuser cm
					JOIN startyfreecontribute sc ON sc.id = cm.c_sc_id
					GROUP BY
						sc.sc_userid
				)c ON c.sc_userid = u.id
				WHERE
					u.delete_flag = 0
				AND ui.model_type <> 0
				AND ui.model_id <> ''
				ORDER BY
					charmnum DESC
				LIMIT $num";
// 		print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//tiary投稿者カワイイ情報
	function selectEntryerRankdata($num=5){
		$sql = "SELECT
					u.id,
					ui.username,
					ui.nickname,
					ui.userpic,
					c.charmnum,
					my.mycharmnum
				FROM
					users u
				JOIN users_info ui ON ui.userid = u.id
				JOIN(
					SELECT
						count(cm.c_sc_id)charmnum,
						sc.sc_userid
					FROM
						charmuser cm
					JOIN startyfreecontribute sc ON sc.id = cm.c_sc_id
					GROUP BY
						sc.sc_userid
				)c ON c.sc_userid = u.id
				JOIN(
					SELECT
						count(sc1.sc_userid)mycharmnum,
						sc1.sc_userid
					FROM
						startyfreecontribute sc1
					JOIN users u1 ON u1.id = sc1.sc_userid
					GROUP BY
						sc1.sc_userid
				)my ON my.sc_userid = u.id
				WHERE
					u.delete_flag = 0
				ORDER BY
					charmnum DESC LIMIT $num ;
			";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//tiary写真カワイイランキング
	function selectKawaiiRankdata($num=5){
		// 		if(!$eid)
		// 		return array();
		$sql = "SELECT
						sc.sc_userid,
						sc.sc_addtime,
						sc.id,
						sc.sc_title,
						sc.sc_img,
						ui.username,
						ui.nickname,
						c.cnum
					FROM
						startyfreecontribute sc
					JOIN users_info ui ON ui.userid = sc.sc_userid
					LEFT JOIN(
						SELECT
							c_sc_id cscid,
							count(c_sc_id)cnum
						FROM
							charmuser
						GROUP BY
							c_sc_id
					)c ON c.cscid = sc.id
					WHERE
						sc.sc_delete_flag = 0
					AND sc.sc_secret_flag = 0
					ORDER BY
						IFNULL(c.cnum, 0)DESC
					LIMIT $num";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	//店舗ランキング情報取得
	function selectShopRankdata($num=5){
		$sql = "SELECT
					sp.id,
					sp.shop_category,
					sp.shop_name,
					IFNULL(c.cnum,0) cnum,
					sy.picture_1 shop_img
				FROM
					shoptbl sp
				LEFT JOIN(
					SELECT
						sc.sc_shop_id,
						count(sc.sc_shop_id)cnum
					FROM
						startyfreecontribute sc
					WHERE
						sc.sc_delete_flag = 0
					AND sc.sc_secret_flag = 0
					GROUP BY
						sc.sc_shop_id
				)c ON c.sc_shop_id = sp.id
				LEFT JOIN shoptbl_yuuryo sy ON sy.shop_id = sp.id
				WHERE
					sp.shop_delete_flag = 0
				ORDER BY
					cnum DESC
				LIMIT $num ";
		// 				print $sql;
		$data = $this->query($sql);
		return $data;
	}

	function selectTiaryUserID($mid){
		if(!$mid)
		return array();

		$sql = "SELECT userid FROM users_info WHERE model_id = $mid ";
		//     	print $sql;
		$data = $this->query($sql);
		return $data[0]["userid"];
	}
	
	//ログインID確認
	function selectCheckUser($email,$birthday){
		if(!$email)
		return array();
		$sql = "SELECT u.username,u.password FROM users u JOIN  users_info ui ON ui.userid = u.id WHERE u.email='$email' AND ui.birthday = '$birthday'";
		//print $sql;
		$data = $this->query($sql);
		return $data[0];
	}
}