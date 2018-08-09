<?php
namespace app\weixin\controller;
use think\Controller;

class Index extends Controller{
	
	private $token = 'wxin9499';
	public function index(){
		$echoStr = input('echostr');
				 
		if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
		$this->responseMsg();
	}
	
	
	private function checkSignature(){
		
        $signature = input('signature');
        $timestamp = input('timestamp');
        $nonce = input('nonce') ;	
        		
		$token = $this->token;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	
	
    public function responseMsg(){
		//get post data, May be due to the different environments
		$postStr = input('HTTP_RAW_POST_DATA');

      	//extract post data
		if (!empty($postStr)){

      	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>"; 
							
				$array = ['php','js','jq','web','css','c++','c#','java'];          
				if(!empty( $keyword ))
                {
                	
                	if(in_array($keyword,$array)){
                		$contentStr = '哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈!';
                	}else{
                		$contentStr = '你这是在逗我吗!';
                	}
              		$msgType = "text";                	
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
	
		
	
}
?>