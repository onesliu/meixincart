<?php

class ControllerWeixinWeixin extends Controller { 
	public function index() {
	}
	
	public function weixin_init() {
		// 读取微信接入配置
		$this->appid = $this->config->get('weixin_appid');
		$this->appsecret = $this->config->get('weixin_appsecret');
		$this->token = $this->config->get('weixin_token');

		// 验证微信服务器
		if ($this->token == null) {
			$this->errorReturn(-1, "微信token未配置");
			$this->log->write("微信token未配置");
			return false;
		}
		
		// 验证通过且不是首次验证
		// 读取本地保存的access_token，没读到就去微信服务器取
		$this->access_token = $this->config->get('weixin_access_token');
		$this->token_expire = $this->config->get('weixin_token_expire');
		$this->token_starttime = $this->config->get('weixin_token_starttime');
		// 读取微信支付配置
		$this->paysignkey = $this->config->get('weixin_paysignkey');
		$this->partnerid = $this->config->get('weixin_partnerid');
		$this->partnerkey = $this->config->get('weixin_partnerkey');
		
		// 获取新的access_token
		$this->load->model('setting/setting');
		$this->load->model('weixin/access_token');
		if (null == $this->access_token || null == $this->token_starttime || null == $this->token_expire ||
			(time() - $this->token_starttime >= $this->token_expire)) {

			$this->access_token = $this->model_weixin_access_token->get($this->config->get('weixin_appid'),
				$this->config->get('weixin_appsecret'));
			if ($this->access_token == false) {
				// 读取access_token失败
				$this->errorReturn(-1, "从微信服务器取access_token失败");
				$this->log->write("从微信服务器取access_token失败");
				return false;
			}
		}
		
		return true;
	}
	
	public function errorReturn($errcode, $msg) {
		$ret = new stdClass();
		$ret->errcode = $errcode;
		$ret->errmsg = $msg;
		$this->response->setOutput(json_encode($ret));
	}
	
	public function postToWx($url, $content) {
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
		
		return $res;
	}
	
	public function makeNewsMsg($openid, $messages) {
		$msg = "";
		foreach($messages as $message) {
			$msg .= sprintf("{\"title\":\"%s\",\"description\":\"%s\",\"url\":\"%s\",\"picurl\":\"%s\"},",
					$message['title'], $message['description'], $message['url'], $message['picurl']);
		}
		$msg = trim($msg, ",");
		$omsg = "{
		    \"touser\":\"$openid\",
		    \"msgtype\":\"news\",
		    \"news\": {\"articles\": [$msg]}
		}";
	}
}

?>