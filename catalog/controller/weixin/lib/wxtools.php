<?php

/*微信订单编号格式：
 * 平台：0-9 公众号支付(1)、小额刷卡(2)
 * 支付类型：0-9 JSAPI(0)、NATIVE(1)、APP支付(2)
 * 业务类型：0-9 菜鸽子(0)、快消品、等等
 * 保留：00
 * 时间：20040801150101 当前时间，年月日时分秒
*/
function new_wx_orderid($platform = 1, $paytype = 0, $btype = 0, $reserve = 0) {
	return sprintf("%d%d%d%02d%s", $platform, $paytype, $btype, $reserve, strftime('%Y%m%d%H%M%S'));
}

function postToWx($url, $content) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
	$ret['content'] = curl_exec($ch);
	$ret['rescode'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	return $ret;
}

function getFromWx($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
	$ret['content'] = curl_exec($ch);
	$ret['rescode'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	return $ret;
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
		$this->params[strtolower(trim($key))] = trim($val);
	}
	
	public function get($key) {
		return $this->params[$key];
	}
	
	private function psort() {
		ksort($this->params);
	}
	
	private function make_param_str() {
		$this->ksort();
		$pstr = "";
		foreach($this->params as $key => $val) {
			if ($key != 'sign' && $val != null && $val != "") {
				$pstr .= "$key=$val&";
			}
		}
		return trim($pstr, "&");
	}
	
	private function sign_make($key) {
		$pstr = $this->make_param_str();
		$pstr .= "key=$key";
		return strtoupper(md5($pstr));
	}
	
	public function make_addr_sign() {
		$pstr = $this->make_param_str();
		return sha1($pstr);
	}
	
	public function make_request($key) {
		$xml = new SimpleXMLExtend("<xml></xml>");
		foreach($this->params as $key => $val) {
			if ($val != null || $val != "") {
				if (is_string($val))
					$xml->addCData($key, $val);
				else
					$xml->addChild($key, $val);
			}
		}
		$xml->addCData('sign', $this->sign_make($key));
		return $xml->asXML();
	}
	
	public function parse_response($xmlstr, $key) {
		//解析xml并写入params数组
		$xml = new SimpleXMLExtend($xmlstr);
		unset($this->params);
		$this->params = array();
		$xmlarr = get_object_vars($xml);
		foreach ($xmlarr as $k => $val) {
			$this->add_param($this->params[$k],(string)$val);
		}
		
		//验证签名
		if (!isset($this->params['sign'])) return false;
		if ($this->params['sign'] != $this->sign_make($key)) return false;
		return true;
	}
}
?>