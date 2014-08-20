<?php

class ControllerWeixinWeixin extends Controller { 
	public function index() {
		
		if ($this->weixin_init() != true) {
			return; //首次验证或初始化失败
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
				$userinfo = $this->model_weixin_get_userinfo->getUserInfo($this->access_token, $this->WeixinFromUserName);
			}
			else if ($this->WeixinMsgType == 'event' && $this->WeixinEvent == 'unsubscribe') {
				//注销用户
				$this->model_weixin_get_userinfo->unSubscribeUser($this->WeixinFromUserName);
			}
			else if ($this->WeixinMsgType == 'event' && $this->WeixinEvent == 'CLICK') {
				//发送自动应答消息，当用户点击该图文消息时，自动登录到商城并跳转到首页
				$param = "index.php?route=weixin/login&email=$this->WeixinFromUserName";
				//菜单消息事件
				if ($this->WeixinEventKey == 'V1001_BUY_NOW') {
					$this->load->model("weixin/auto_reply");
					$reply = $this->model_weixin_auto_reply->getReply($this->WeixinFromUserName,
						$this->WeixinToUserName, 'order');
					if ($reply != false) {
						$reply = str_replace('index.php', $param, $reply);
						$this->response->setOutput($reply);
						return;
					}
				}
				else if ($this->WeixinEventKey == 'V1001_SELF_INFO') {
					$this->load->model("weixin/auto_reply");
					$reply = $this->model_weixin_auto_reply->getReply($this->WeixinFromUserName,
						$this->WeixinToUserName, 'order');
					if ($reply != false) {
						$reply = str_replace('index.php', $param, $reply);
						$this->response->setOutput($reply);
						return;
					}
				}
			}
			else if ($this->WeixinMsgType == 'event' && $this->WeixinEvent == 'VIEW') {
				//直接自动登录到商城并跳转到首页
			}
			else if ($this->WeixinMsgType == 'text') {
				//测试自动回复
				$this->load->model("weixin/auto_reply");
				$reply = $this->model_weixin_auto_reply->getReply($this->WeixinFromUserName,
					$this->WeixinToUserName, $this->WeixinContent);
				if ($reply != false) {
					$this->response->setOutput($reply);
					return;
				}
			}
		}
		$this->response->setOutput("");
	}
	
	public function weixin_init() {
		// 读取微信接入配置
		$this->appid = $this->config->get('weixin_appid');
		$this->appsecret = $this->config->get('weixin_appsecret');
		$this->token = $this->config->get('weixin_token');

		// 验证微信服务器
		if ($this->token == null) {
			$this->response->setOutput("");
			$this->log->write("微信token未配置");
			return false;
		}
		
		$valid_result = $this->valid($this->token);
		if ($valid_result == false) {
			$this->response->setOutput("");
			$this->log->write("微信接入验证失败");
			return false;
		}
		else if (is_string($valid_result)){
			// 首次验证，返回echostr
			$this->response->setOutput($valid_result);
			return '';
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
				$this->response->setOutput("");
				$this->log->write("从微信服务器取access_token失败");
				return false;
			}
		}
		
		return true;
	}
	
	private function valid($token)
    {
    	if ($this->request->server['REQUEST_METHOD'] == 'GET') {
    		if (isset($this->request->get["signature"])) {
		        $signature = $this->request->get["signature"];
		        $timestamp = $this->request->get["timestamp"];
		        $nonce = $this->request->get["nonce"];
		        $echostr = $this->request->get['echostr'];
	
	    		if($this->checkSignature($signature, $timestamp, $nonce, $token)){
		        	return $echostr;
		        }
    		}
    	}
    	else {
    		if (isset($this->request->get["signature"])) {
		        $signature = $this->request->get["signature"];
		        $timestamp = $this->request->get["timestamp"];
		        $nonce = $this->request->get["nonce"];	
	
		        if($this->checkSignature($signature, $timestamp, $nonce, $token)){
		        	return true;
		        }
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