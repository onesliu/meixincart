<?php

class ModelWeixinGetUserinfo extends Model {
	protected $errcode;
	protected $errmsg;
	
	public function getUserInfo($access_token, $openid) {
		
		if ($access_token == null || $openid == null)
			return false;

		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
		$res = curl_exec($ch);
		$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$result = json_decode($res);
		
		if (isset($result->subscribe)) {
			if ($result->subscribe == 1) {
				$this->save($openid, $result);
				return $result;
			}
			else {
				$this->log->write("tried to get unsubscribe user infomation, openid = $openid");
			}
		}
		else {
			$this->errcode = $result->errcode;
			$this->errmsg = $result->errmsg;
		}
		return false;
	}
	
	public function unSubscribeUser($openid) {
		$this->db->query(sprintf("update %scustomer set subscribe=0, status=0, approved=0 where openid='%s'", DB_PREFIX, $openid));
	}
	
	private function save($openid, $info) {
		$q = $this->db->query(sprintf("select count(*) as cnt from %scustomer where openid='%s'", DB_PREFIX, $openid));
		if ($q->row["cnt"] <= 0) {
			$this->db->query(sprintf("insert into %scustomer
			(subscribe,openid,nickname,sex,city,country,province,language,headimgurl,subscribe_time,
			email,firstname,password,customer_group_id,date_added,status,lastname,approved) values (%d, '%s', '%s', %d, '%s',
			'%s', '%s', '%s', '%s', %d, '%s', '%s', SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('%s'))))),
			1, now(), 1, '%s', 1)", DB_PREFIX,
			$info->subscribe, $info->openid, $info->nickname, $info->sex, $info->city,
			$info->country, $info->province, $info->language, $info->headimgurl,
			$info->subscribe_time, $info->openid, $info->nickname, WEIXIN_USERPWD, $info->nickname));
		}
		else {
			$this->db->query(sprintf("update %scustomer set nickname='%s', sex=%d, city='%s', country='%s',
			province='%s', language='%s', headimgurl='%s', subscribe_time=%d, firstname='%s', email='%s',
			subscribe=%d, lastname='%s', approved=1,
			status=1, date_added=now(), password=SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('%s')))))
			where openid='%s'",
			DB_PREFIX, $info->nickname, $info->sex, $info->city, $info->country, $info->province,
			$info->language, $info->headimgurl, $info->subscribe_time, $info->nickname, $info->openid,
			$info->subscribe, $info->nickname, WEIXIN_USERPWD, $openid));
		}
	}
}
?>