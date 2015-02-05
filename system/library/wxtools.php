<?php
include_once(DIR_SYSTEM."/library/TenpayHttpClient.class.php");

class WeixinTools {
	public function postToWx($url, $content) {
		$cli = new TenpayHttpClient();
		$cli->setReqContent("$url?$content");
		$cli->setMethod('post');
		if ($cli->call() != true) {
			return false;
		}
			
		return $cli->resContent();
	}
	
	public function getFromWx($url) {
		$cli = new TenpayHttpClient();
		$cli->setReqContent("$url");
		$cli->setMethod('get');
		if ($cli->call() != true) {
			return false;
		}
			
		return $cli->resContent();
	}
	
	public function sslPostToWx($url, $content) {
		$cli = new TenpayHttpClient();
		$cli->setReqContent("$url?$content");
		$cli->setMethod('post');
		if (!file_exists('/etc/httpd/certs/1220519101.pem'))
			return false;
		$cli->setCertInfo('/etc/httpd/certs/1220519101.pem', '1220519101');
		$cli->setCaInfo('/etc/httpd/certs/cacert.pem');
		if ($cli->call() != true) {
			return false;
		}
			
		return $cli->resContent();
	}
	
	public function sslGetFromWx($url) {
		$cli = new TenpayHttpClient();
		$cli->setReqContent("$url");
		$cli->setMethod('get');
		if (!file_exists('/etc/httpd/certs/1220519101.pem'))
			return false;
		$cli->setCertInfo('/etc/httpd/certs/1220519101.pem', '1220519101');
		$cli->setCaInfo('/etc/httpd/certs/cacert.pem');
		if ($cli->call() != true) {
			return false;
		}
			
		return $cli->resContent();
	}
	
	public function prepareOauthUrl($remote_file, $appid) {
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
		$url = str_replace('APPID', $appid, $url);
		
		$link = "http://".MY_DOMAIN."/pay/weixin.php?route=weixin/login";
		if (strlen($remote_file) > 0) {
			$link .= "&jump=$remote_file";
		}
		$link = str_replace('REDIRECT_URI', urlencode($link), $url);
		return $link;
	}
	
	public function prepareMenu($menu_def, $appid) {
		$ret = preg_match_all("/AUTO_LOGIN:([a-zA-Z0-9\.\/\\_-]*)/", $menu_def, $matches);
		if ($ret > 0) {
	        foreach($matches[1] as $remote_file) {
	        	if (strlen($remote_file) == 0) return "";
                $link = $this->prepareOauthUrl($remote_file, $appid);
                $menu_def = str_replace("AUTO_LOGIN:$remote_file", $link, $menu_def);
	        }
		}
		
		$host = "http://".MY_DOMAIN."/";
		$menu_def = str_replace("HOST:", $host, $menu_def);
		
		return $menu_def;
	}
}

class SimpleXMLExtend extends SimpleXMLElement
{
  public function addCData($nodename,$cdata_text)
  {
    $node = $this->addChild($nodename); //Added a nodename to create inside the function
    $node = dom_import_simplexml($node);
    $no = $node->ownerDocument;
    $node->appendChild($no->createCDATASection($cdata_text));
  }
}

class PayHelper {
	
	var $params = array();
	
	public function add_param($key, $val) {
		if (is_string($val))
			$this->params[trim($key)] = trim($val);
		else
			$this->params[trim($key)] = $val;
	}
	
	public function get($key) {
		return $this->params[$key];
	}
	
	private function psort() {
		ksort($this->params);
	}
	
	private function make_param_str() {
		$this->psort();
		$pstr = "";
		foreach($this->params as $key => $val) {
			if ($key != 'sign' && $val != null && $val != "") {
				$pstr .= "$key=$val&";
			}
		}
		return trim($pstr, "&");
	}
	
	public function sign_make($key) {
		$pstr = $this->make_param_str();
		$pstr .= "&key=".$key;
		return strtoupper(md5($pstr));
	}
	
	public function make_addr_sign() {
		$pstr = $this->make_param_str();
		return sha1($pstr);
	}
	
	public function make_request($key) {
		$xml = new SimpleXMLExtend("<xml></xml>");
		foreach($this->params as $k => $val) {
			if ($val != null || $val != "") {
				if (is_string($val))
					$xml->addCData($k, $val);
				else
					$xml->addChild($k, $val);
			}
		}
		$xml->addCData('sign', $this->sign_make($key));
		return $xml->asXML();
	}
	
	public function make_param_xml() {
		$xml = new SimpleXMLExtend("<xml></xml>");
		foreach($this->params as $k => $val) {
			if ($val != null || $val != "") {
				if (is_string($val))
					$xml->addCData($k, $val);
				else
					$xml->addChild($k, $val);
			}
		}
		return $xml->asXML();
	}
	
	public function parse_response($xmlstr) {
		//解析xml并写入params数组
		$xml = new SimpleXMLExtend($xmlstr);
		unset($this->params);
		$this->params = array();
		$xmlarr = get_object_vars($xml);
		foreach ($xmlarr as $k => $val) {
			$this->add_param($k,(string)$val);
		}
		return $xml;
	}
	
	public function sign_verify($key) {
		//验证签名
		if (!isset($this->params['sign'])) return false;
		if ($this->params['sign'] != $this->sign_make($key)) return false;
		return true;
	}
}
?>