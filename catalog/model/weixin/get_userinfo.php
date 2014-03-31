<?php

class ModelWeixinGetUserinfo extends Model {
	protected $errcode;
	protected $errmsg;
	
	public function getUserInfo($access_token, $openid) {
		$this->save('', 0, 0);
		
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
				$this->save($result);
				return true;
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
	
	private function save($openid, $info) {
		$q = $this->db->query(sprintf("select count(*) as cnt from %scustomer where openid='%s'", DB_PREFIX, $openid));
		if ($q->row["cnt"] <= 0) {
			$this->db->query(sprintf("insert into %scustomer"));
		}
		else {
			
		}
		$this->config->set('weixin_access_token', $access_token);
		$this->config->set('weixin_token_expire', $expire_time);
		$this->config->set('weixin_token_starttime', $startime);
		$data = array('weixin_access_token' => $access_token,
						'weixin_token_expire' => $expire_time,
						'weixin_token_starttime' => $startime);
		$this->model_setting_setting->editSetting(1, $data);
		
		$this->log->write("Get weixin access_token: $access_token, $expire_time");
	}
}
?>