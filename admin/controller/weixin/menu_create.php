<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinMenuCreate extends ControllerWeixinWeixin {
	
	public function index() {
		
		if ($this->weixin_init() != true) {
			return; //首次验证或初始化失败
		}
				
		$menu_def = $this->prepare_menu_def($this->config->get('weixin_menu'));
		
		//创建菜单
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->access_token;
		$res = $this->postToWx($url, $menu_def);
		$this->response->setOutput($res);
	}
	
	private function prepare_menu_def($menu_def) {
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&response_type=code&scope=snsapi_base&state=1#wechat_redirect&redirect_uri=REDIRECT_URI";
		$url = str_replace('APPID', $this->config->get('weixin_appid'), $url);
		
		$u = "http://".MY_DOMAIN."/pay/weixin.php?route=weixin/login";
		$ret = preg_match_all("/\"AUTO_LOGIN:(.*)\"/", $menu_def, $matches);
		if ($ret > 0) {
		        foreach($matches[1] as $param) {
		                if (strlen($param) > 0)
		                        $link = $u."&jump=$param";
		                else
		                        $link = $u;
		                $link = str_replace('REDIRECT_URI', urlencode($link), $url);
		                $menu_def = str_replace("\"AUTO_LOGIN:$param\"", '"'.$link.'"', $menu_def);
		        }
		}
		
		return $menu_def;
	}
}
?>