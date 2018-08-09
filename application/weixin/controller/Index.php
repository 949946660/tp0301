<?php
namespace app\weixin\controller;
class Index extends Common{
	
	public function index(){		
		//获取微信推送的信息
		switch ($this->msgtype) {
			case 'text':
				$this->textMsg();
				break;
				
			case 'image':
				$this->imgMsg();
				break;
				
			case 'event':
				$this->eventMsg();
				break;
		}

	}
	
	
	
	public function textMsg(){
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
		if(!empty( $this->keyword )){
       	
        	if(in_array($this->keyword,$array)){
        		$contentStr = '哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈!';
        	}elseif($this->keyword == '新闻'){
        			$this->imgtextMsg();
        	}else{
        		$contentStr = '你这是在逗我吗!';
        	}
      		$msgType = "text";                	
        	$resultStr = sprintf($textTpl, $this->funame, $this->tuname, $time, $msgType, $contentStr);
        	echo $resultStr;
        }else{
        	echo "Input something...";
        }
    }
	
	
	
	public function imgMsg(){
        $time = time();
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>"; 
		
    	$contentStr = '哎呦，不错喔!';      
  		$msgType = "text";                	
    	$resultStr = sprintf($textTpl, $this->funame, $this->tuname, $time, $msgType, $contentStr);
    	echo $resultStr;      
    }
	
	
	//关注事件
	public function eventMsg(){
		$arr = [];
		$arr['openid'] = $this->funame;
		if($this->event == 'subscribe'){
			//关注			
			$arr['ctime'] = $this->ctime;
			db('event')->insert($arr);
			
			//关注回复信息
			$time = time();
	        $textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>"; 
			
	    	$contentStr = '欢迎关注000000'."\n".'人生如戏，全靠演技'."\n".'人生如戏，全靠演技';    
	  		$msgType = "text";                	
	    	$resultStr = sprintf($textTpl, $this->funame, $this->tuname, $time, $msgType, $contentStr);
	    	echo $resultStr;   
		}else{
			//取消关注
			db('event')->where(['openid'=>$arr['openid']])->delete();
			
		}
	}
	
	
	
    function imgtextMsg(){
    	$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>12345678</CreateTime>
					<MsgType><![CDATA[news]]></MsgType>
					<ArticleCount>%d</ArticleCount>
					<Articles>%s</Articles>
					</xml>";
		$articles = "<item>
					<Title><![CDATA[%s]]></Title>
					<Description><![CDATA[%s]]></Description>
					<PicUrl><![CDATA[%s]]></PicUrl>
					<Url><![CDATA[%s]]></Url>
					</item>";
		$news = [
					[
						'Title'=>'回眸一笑百媚生，倾尽所有',
						'Description'=>'大吉大利，今晚吃鸡0.0',
						'PicUrl'=>'http://www.itdiandi.com/wxin9499/public/img/4.jpg',
						'Url'=>'http://www.itdiandi.com/',
					],
					[
						'Title'=>'等你成熟，等你5年，最后还是这个结局',
						'Description'=>'纪凌尘与阚清子，女人能有几个五年...',
						'PicUrl'=>'http://www.itdiandi.com/wxin9499/public/img/3.jpg',
						'Url'=>'http://www.itdiandi.com/',
					]
		];

		$newstr = '';
		foreach($news as $k=>$v){
			$newstr .= sprintf($articles, $v['Title'], $v['Description'], $v['PicUrl'],$v['Url']);
		}
		$count = count($news);
    	$resultStr = sprintf($textTpl, $this->funame, $this->tuname,$count,$newstr);
    	echo $resultStr;
    }
    
    
    
    function _click(){
    	if($this->eventkey == 'S'){

    	}elseif($this->eventkey == 'AS'){

    	}
    }


}
	


?>