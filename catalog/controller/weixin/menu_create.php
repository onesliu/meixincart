<?php
$menu_def = '{
     "button":[
     {	
          "type":"click",
          "name":"我要买菜",
          "key":"V1001_BUY_NOW"
      },
      {
           "type":"click",
           "name":"会员信息",
           "key":"V1001_SELF_INFO"
      },
      {
           "name":"青悠悠",
           "sub_button":[{	
               "type":"view",
               "name":"关于我们",
               "url":"http://oc.ngrok.com/opencart/"
           }]
       }]
}';

class ControllerWeixinMenuCreate extends Controller {
	public function index() {
		global $menu_def;
		
		// 读取微信配置信息
		$token = $this->config->get('weixin_token');
		
		// 读取本地保存的access_token，没读到就去微信服务器取
		$access_token = $this->config->get('weixin_access_token');
		$token_expire = $this->config->get('weixin_token_expire');
		$token_starttime = $this->config->get('weixin_token_starttime');
		
		$this->load->model('setting/setting');
		$this->load->model('weixin/access_token');
		if (null == $access_token || null == $token_starttime || null == $token_expire ||
			(time() - $token_starttime >= $token_expire)) {

			$access_token = $this->model_weixin_access_token->get($this->config->get('weixin_appid'),
				$this->config->get('weixin_appsecret'));
			if ($access_token == false) {
				// 读取access_token失败
				$this->response->setOutput("got weixin access_token failed.");
				return;
			}
		}
		
		//创建菜单
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $menu_def);
		$res = curl_exec($ch);
		$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$this->log->write($url);
		$this->log->write($rescode." ".$res);
		$this->response->setOutput($res);
		/*
		$result = json_decode($res);
		if (!isset($result->errcode)) {
			$this->errcode = $result->errcode;
			$this->errmsg = $result->errmsg;
		}
		*/
	}
}
?>