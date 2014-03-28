<?php

class AccessToken {
	protected $registry;
	protected $access_token;
	protected $expires_in;
	protected $errcode;
	protected $errmsg;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function get($appid, $secret) {
		if ($appid == null || $secret == null)
			return false;

		$this->save('', 0, 0);
		
		$token = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret");
		$result = json_decode($token);
		
		if (isset($result->access_token)) {
			$this->access_token = $result->access_token;
			$this->expires_in = $result->expires_in;
			$this->save($result->access_token, $result->expires_in, time());
			return true;
		}
		else {
			$this->errcode = $result->errcode;
			$this->errmsg = $result->errmsg;
		}
		return false;
	}
	
	private function save($access_token, $expire_time, $startime) {
		$this->register->config->set('weixin_access_token', $access_token);
		$this->register->config->set('weixin_token_expire', $expire_time);
		$this->register->config->set('weixin_token_starttime', $startime);
		$this->register->model_setting_setting->editSetting('weixin_access_token', $access_token);
		$this->register->model_setting_setting->editSetting('weixin_token_expire', $expire_time);
		$this->register->model_setting_setting->editSetting('weixin_token_starttime', $startime);
	}
}
?>