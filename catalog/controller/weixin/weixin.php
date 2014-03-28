<?php

class ControllerWeixinWeixin extends Controller { 
	public function index() {
		
		// 读取微信配置信息
		$token = $this->config->get('weixin_token');
		
		// 验证微信服务器
		$valid_result = $this->valid();
		if ($token == null || $valid_result == false) {
			// 返回错误
		}
		else if (is_string($valid_result)) {
			// 首次验证，返回echostr
			
		}
		
		// 验证通过且不是首次验证
		// 读取本地保存的access_token，没读到就去微信服务器取
		$access_token = $this->config->get('weixin_access_token');
		$token_expire = $this->config->get('weixin_token_expire');
		$token_starttime = $this->config->get('weixin_token_starttime');
		
		$this->load->model('setting/setting');
		
		if (null == $access_token || null == $token_starttime || null == $token_expire ||
			(time() - $token_starttime >= $token_expire)) {
			require('access_token.php');
			
			$AccessToken = new AccessToken($this->registry);
			if ($AccessToken->get($this->config->get('weixin_appid'),
				$this->config->get('weixin_appsecret')) == false) {
				// 读取access_token失败
			}
			else {
				$access_token = $AccessToken->access_token;
				$token_expire = $AccessToken->expires_in;
			}
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
		}
	}
	
	private function valid($token)
    {
    	if (isset($this->request->get['signature'])) {
	        $signature = $this->request->get["signature"];
	        $timestamp = $this->request->get["timestamp"];
	        $nonce = $this->request->get["nonce"];	
    		$echoStr = $this->request->get["echostr"];

    		if($this->checkSignature($signature, $timestamp, $nonce, $token)){
	        	return $echoStr;
	        }
    	}
    	else if (isset($this->request->post['signature'])) {
	        $signature = $this->request->get["signature"];
	        $timestamp = $this->request->get["timestamp"];
	        $nonce = $this->request->get["nonce"];	

	        if($this->checkSignature($signature, $timestamp, $nonce, $token)){
	        	return true;
	        }
    	}

        return false;
    }

	private function checkSignature($signature, $timestamp, $nonce, $token)
	{
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>