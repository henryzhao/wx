<?php
    $weixinObj=new weixinClass();
	$weixinObj->index();
    $weixinObj->definedItem();
class weixinClass
{
 public function index() {
        $nonce=$_GET['nonce'];
        $timestamp=$_GET['timestamp'];
        $echostr=$_GET['echostr'];
        $signature=$_GET['signature'];
        $token='weixin';
        $array=array();
        $array=array($nonce,$timestamp,$token);
        sort($array);
        $str=sha1(implode($array));
        if($str==$signature && $echostr){
        header('content-type:text');
        echo $echostr;
        exit;
        }
        else{
       		$this->reponseMsg();
        }
    }
    public function reponseMsg(){
    	//$postArr=$GLOBALS['HTTP_RAW_POST_DATA'];
        $postArr=file_get_contents('php://input');
        $postObj=simplexml_load_string($postArr);
        if(strtolower($postObj->MsgType)=='event'){
        	if(strtolower($postObj->Event)=='subscribe'){
				$toUser=$postObj->FromUserName;
                $fromUser=$postObj->ToUserName;
                $time=time();
                $msgType='text';
                $content='欢迎关注追求体育，此公众号现处于开发阶段，更多功能敬请期待';
                $template="<xml>
                			<ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
                $info=sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
                echo $info;
            }
        }
    }
    function http_curl($url,$type='get',$res='json',$arr=''){
    	$ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        if($type=='post'){
        	curl_setopt($ch.CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }
        $output=curl_exec($ch);
        curl_close($ch);
        if($res=='json'){
            if(curl_errno($ch)){
            	return curl_error($ch);
            }else{
            	return json_decode($output,true);
            }	
        }
    }
    public function getWxAccessToken(){
    	if($_SESSION['access_token'] && $_SESSION['expire_time']>time()){
        	return $_SESSION['access_token'];
        }else{
        	$appid='wxf1d75feab13b1472';
            $appsecret='e2166824d73b54c3ba3e894be8de23fb';
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $res=$this->http_curl($url,'get','json');
            $access_token=$res['access_token'];
            $_SESSION['access_token']=$access_token;
            $_SESSION['expire_time']=time()+7000;
            return $access_token;
        }
    }
    public function definedItem(){
        header('content-type:text/html;charset=utf-8');
        $access_token=$this->getWxAccessToken();
    	$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $postArr=array(
            'button'=>array(
                    array(
                        'name'=>urlencode('追求体育'),
                        'sub_button'=>array(
                        	array(
                        		'name'=>urlencode('登陆/注册'),
                        		'type'=>'view',
                        		'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf1d75feab13b1472&redirect_uri=http://www.zhuiqiuwang.net&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect',
                        		),
                        	array(
                        		'name'=>urlencode('积分兑换'),
                        		'type'=>'view',
                        		'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf1d75feab13b1472&redirect_uri=http://www.zhuiqiuwang.net&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect',
                        		),
                        	),
                    ),
                    array(
                        'name'=>urlencode('约球'),
                        'type'=>'view',
                        'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf1d75feab13b1472&redirect_uri=http://www.zhuiqiuwang.net&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect',
                    ),
                     array(
                        'name'=>urlencode('关于我们'),
                        'type'=>'view',
                        'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf1d75feab13b1472&redirect_uri=http://www.zhuiqiuwang.net&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect',
                    ),
            ),
        	
        );
        $postJson=urldecode(json_encode($postArr));
        $res=$this->http_curl($url,'post','json',$postJson);
    }
}
?>