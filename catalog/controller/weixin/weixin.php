<?php

class ControllerWeixinWeixin extends Controller { 
	public function index() {
		
		// 读取微信配置信息
		$token = $this->config->get('weixin_token');

		// 验证微信服务器
		if ($token == null) {
			$this->response->setOutput("");
			return;
		}
		
		$valid_result = $this->valid($token);
		if ($valid_result == false) {
			$this->response->setOutput("");
			return;
		}
		else if (is_string($valid_result)){
			// 首次验证，返回echostr
			$this->response->setOutput($valid_result);
			return;
		}
		
		// 验证通过且不是首次验证
		// 读取本地保存的access_token，没读到就去微信服务器取
		$access_token = $this->config->get('weixin_access_token');
		$token_expire = $this->config->get('weixin_token_expire');
		$token_starttime = $this->config->get('weixin_token_starttime');
		
		$this->load->model('setting/setting');
		$this->load->model('weixin/access_token');
		//$this->log->write($access_token." ".$token_starttime." ".$token_expire." ".(time() - $token_starttime));
		if (null == $access_token || null == $token_starttime || null == $token_expire ||
			(time() - $token_starttime >= $token_expire)) {

			$access_token = $this->model_weixin_access_token->get($this->config->get('weixin_appid'),
				$this->config->get('weixin_appsecret'));
			if ($access_token == false) {
				// 读取access_token失败
				$this->response->setOutput("");
				return;
			}
		}
		
		// 接收到消息或事件
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			//保存到数据库
			$this->load->model('weixin/message');
			$xmlstr = file_get_contents("php://input");
			$this->model_weixin_message->addAll($xmlstr);
			
			//关注事件与取消关注事件
			$this->load->model('weixin/get_userinfo');
			if ($this->WeixinMsgType == 'event' && $this->WeixinEvent == 'subscribe') {
				//取用户信息，并自动注册到商城
				$userinfo = $this->model_weixin_get_userinfo->getUserInfo($access_token, $this->WeixinFromUserName);
			}
			else if ($this->WeixinMsgType == 'event' && $this->WeixinEvent == 'unsubscribe') {
				//注销用户
				$this->model_weixin_get_userinfo->unSubscribeUser($this->WeixinFromUserName);
			}
			else if ($this->WeixinMsgType == 'text') {
				//测试自动回复
				$test = sprintf("<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>", $this->WeixinFromUserName, $this->WeixinToUserName, time());
				$this->response->setOutput($test);
				return;
			}
		}
		$this->response->setOutput("");
	}
	
	private function valid($token)
    {
    	if ($this->request->server['REQUEST_METHOD'] == 'GET') {
	        $signature = $this->request->get["signature"];
	        $timestamp = $this->request->get["timestamp"];
	        $nonce = $this->request->get["nonce"];
	        $echostr = $this->request->get['echostr'];

    		if($this->checkSignature($signature, $timestamp, $nonce, $token)){
	        	return $echostr;
	        }
    	}
    	else {
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