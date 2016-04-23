<?php
namespace LaneWeChat\Core;
/**
 * 微信Access_Token的获取与过期检查
 * Created by Lane.
 * User: lane
 * Date: 13-12-29
 * Time: 下午5:54
 * Mail: lixuan868686@163.com
 * Website: http://www.lanecn.com
 */
class AccessToken{

    /**
     * 获取微信Access_Token
     */
    public static function getAccessToken(){
        //下面的代码段是原框架的代码段,SAE平台不支持本地write功能,所以要想达到缓存access_token的目的需要用到memcache(缓存)服务
        //兼容SAE平台需开启下面注释掉的一段代码
        //检测本地是否已经拥有access_token，并且检测access_token是否过期
        $accessToken = self::_checkAccessToken();
        if($accessToken === false){
            $accessToken = self::_getAccessToken();
        }
        return $accessToken['access_token'];
        /*
        //下面的代码是在SAE平台上获取access_token的过程
        //初始化memcache,前提是已经开启memcache服务
        $mmc=memcache_init();
        //从memcache之中取值
        $token=memcache_get($mmc,'key');
        //看memcache之中是否的值是否过期/存在,true直接返回 
        if(!empty($token)){
            return $token;
        }else{
            //如果memcache中的值已经过期/不存在,再次请求获取
            $token=self::_getToken();
            //将access_token的值存入memcache并且设置其过期时间2000秒,微信平台默认是7200秒,此处设置的值比7200小就可以
            $val=memcache_set($mmc,'key',$token,0,7000);
            return $token;
        }
        */
    }
    /**
    *@descrpition 从微信服务器获取微信ACCESS_TOKEN
    * @return string
    */
    public static function _getToken(){
        //使用CURL来向指定的TECENT 服务器的API接口发送指定信息啊
        $ch=curl_init();
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.WECHAT_APPID.'&secret='.WECHAT_APPSECRET;
        //针对这样一个url请求,所对应的链接是这样的一个地址.
        curl_setopt($ch, CURLOPT_URL, $url);
        //将请球的结果在exec的时候赋值给参数,而不是直接输出来的
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl中的header头对用户是不可以见到的
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output=curl_exec($ch);
        curl_close($ch);
        $obj=json_decode($output,true);    
        return $obj['access_token'];
}

    /**
     * @descrpition 从微信服务器获取微信ACCESS_TOKEN
     * @return Ambigous|bool
     */
    private static function _getAccessToken(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.WECHAT_APPID.'&secret='.WECHAT_APPSECRET;
        $accessToken = Curl::callWebServer($url, '', 'GET');
        if(!isset($accessToken['access_token'])){
            return Msg::returnErrMsg(MsgConstant::ERROR_GET_ACCESS_TOKEN, '获取ACCESS_TOKEN失败');
        }
        $accessToken['time'] = time();
        $accessTokenJson = json_encode($accessToken);
        //存入数据库
        /**
         * 这里通常我会把access_token存起来，然后用的时候读取，判断是否过期，如果过期就重新调用此方法获取，存取操作请自行完成
         *
         * 请将变量$accessTokenJson给存起来，这个变量是一个字符串
         */
        $f = fopen('access_token', 'w+');
        fwrite($f, $accessTokenJson);
        fclose($f);
        return $accessToken;
    }

    /**
     * @descrpition 检测微信ACCESS_TOKEN是否过期
     *              -10是预留的网络延迟时间
     * @return bool
     */
    private static function _checkAccessToken(){
        //获取access_token。是上面的获取方法获取到后存起来的。
//        $accessToken = YourDatabase::get('access_token');
        $data = file_get_contents('access_token');
        $accessToken['value'] = $data;
        if(!empty($accessToken['value'])){
            $accessToken = json_decode($accessToken['value'], true);
            if(time() - $accessToken['time'] < $accessToken['expires_in']-10){
                return $accessToken;
            }
        }
        return false;
    }
}
?>