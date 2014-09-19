<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinMenuCreate extends ControllerWeixinWeixin {
	
	public function index() {
		
		if ($this->weixin_init() != true) {
			return; //首次验证或初始化失败
		}
				
		$menu_def = $this->prepare_menu_def($this->config->get('weixin_menu'));
		
		//创建菜单
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $menu_def);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
		$res = curl_exec($ch);
		$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$this->response->setOutput($res);
	}
	
	private function prepare_menu_def($menu_def) {
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
		$url = str_replace('APPID', $this->config->get('weixin_appid'), $url);
		$url = str_replace('REDIRECT_URI', urlencode("http://".MY_DOMAIN."/pay/weixin.php?route=weixin/login"), $url);
		return str_replace('AUTO_LOGIN', $url, $menu_def);
	}
}
?>