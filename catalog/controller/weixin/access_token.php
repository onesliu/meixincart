<?php

class AccessToken {
	protected $access_token;
	protected $expires_in;
	protected $errcode;
	protected $errmsg;
	
	public function get($appid, $secret) {
		if ($appid == null || $secret == null)
			return false;
			
		$token = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret");
		$result = json_decode($token);
		
		if (isset($result->access_token)) {
			$this->access_token = $result->access_token;
			$this->expires_in = $result->expires_in;
			return true;
		}
		else {
			$this->errcode = $result->errcode;
			$this->errmsg = $result->errmsg;
		}
		return false;
	}
}
?>