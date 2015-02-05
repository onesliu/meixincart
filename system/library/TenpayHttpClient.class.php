<?php
/**
 * http、https通信类
 * ============================================================================
 * api说明：
 * setReqContent($reqContent),设置请求内容，无论post和get，都用get方式提供
 * getResContent(), 获取应答内容
 * setMethod($method),设置请求方法,post或者get
 * getErrInfo(),获取错误信息
 * setCertInfo($certFile, $certPasswd, $certType="PEM"),设置证书，双向https时需要使用
 * setCaInfo($caFile), 设置CA，格式未pem，不设置则不检查
 * setTimeOut($timeOut)， 设置超时时间，单位秒
 * getResponseCode(), 取返回的http状态码
 * call(),真正调用接口
 * 
 * ============================================================================
 */
class TenpayHttpClient {
	var $reqContent;
	var $resContent;
	var $method;
	var $certFile;
	var $certPasswd;
	var $certType;
	var $caFile;
	var $errInfo;
	var $timeOut;
	var $responseCode;
	
	function __construct() {
		$this->TenpayHttpClient();
	}

	function TenpayHttpClient() {
		$this->reqContent = "";
		$this->resContent = "";
		$this->method = "post";

		$this->certFile = "";
		$this->certPasswd = "";
		$this->certType = "PEM";
		
		$this->caFile = "";
		
		$this->errInfo = "";
		
		$this->timeOut = 120;
		
		$this->responseCode = 0;
		
	}
	function setReqContent($reqContent) {
		$this->reqContent = $reqContent;
	}
	
	function getResContent() {
		return $this->resContent;
	}
	
	function setMethod($method) {
		$this->method = $method;
	}
	
	function getErrInfo() {
		return $this->errInfo;
	}
	
	function setCertInfo($certFile, $certPasswd, $certType="PEM") {
		$this->certFile = $certFile;
		$this->certPasswd = $certPasswd;
		$this->certType = $certType;
	}
	
	function setCaInfo($caFile) {
		$this->caFile = $caFile;
	}
	
	function setTimeOut($timeOut) {
		$this->timeOut = $timeOut;
	}
	
	function call() {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeOut);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);

		$arr = explode("?", $this->reqContent);
		if(count($arr) >= 2 && $this->method == "post") {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_URL, $arr[0]);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arr[1]);
		}else{
			curl_setopt($ch, CURLOPT_URL, $this->reqContent);
		}

		if($this->certFile != "") {
			curl_setopt($ch, CURLOPT_SSLCERT, $this->certFile);
			curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->certPasswd);
			curl_setopt($ch, CURLOPT_SSLCERTTYPE, $this->certType);
		}
		
		if($this->caFile != "") {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_CAINFO, $this->caFile);
		} else {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		
		$res = curl_exec($ch);
		$this->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if ($res == NULL) { 
		   $this->errInfo = "call http err :" . curl_errno($ch) . " - " . curl_error($ch) ;
		   curl_close($ch);
		   return false;
		} else if($this->responseCode  != "200") {
			$this->errInfo = "call http err httpcode=" . $this->responseCode  ;
			curl_close($ch);
			return false;
		}
		
		curl_close($ch);
		$this->resContent = $res;

		
		return true;
	}

	function getResponseCode() {
		return $this->responseCode;
	}
}
?>