<?php

class ModelWeixinQueryOrder extends Model {
	protected $errcode;
	protected $errmsg;
	
	public function query($access_token, $content) {
		
		if ($access_token == null || $content == null)
			return false;

		$url = "https://api.weixin.qq.com/pay/orderquery?access_token=$access_token";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
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

}
?>