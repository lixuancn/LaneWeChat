<?php
namespace LaneWeChat\Core;
/**
 * 微信OAuth2.0获取认证
 * Created by lane.
 * User: lane
 * Date: 14-3-28
 * Time: 下午1:55
 * Mail lixuan868686@163.com
 * Blog http://www.lanecn.com
 */
class WeChatOAuth{
    /**
     * Description: 获取CODE
     * @param $scope snsapi_base不弹出授权页面，只能获得OpenId;snsapi_userinfo弹出授权页面，可以获得所有信息
     * 将会跳转到redirect_uri/?code=CODE&state=STATE 通过GET方式获取code和state
     */
    public static function getCode($redirect_uri, $state=1, $scope='snsapi_base'){
        if($redirect_uri[0] == '/'){
            $redirect_uri = substr($redirect_uri, 1);
        }
        //公众号的唯一标识
        $appid = WECHAT_APPID;
        //授权后重定向的回调链接地址，请使用urlencode对链接进行处理
        $redirect_uri = WECHAT_URL . $redirect_uri;
        $redirect_uri = urlencode($redirect_uri);
        //返回类型，请填写code
        $response_type = 'code';
        //构造请求微信接口的URL
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type='.$response_type.'&scope='.$scope.'&state='.$state.'#wechat_redirect';
        header('Location: '.$url, true, 301);
        //请求微信接口
//        $result = Curl::callWebServer($url);
//        return $result;
    }


    /**
     * Description: 通过code换取网页授权access_token
     * 首先请注意，这里通过code换取的网页授权access_token,与基础支持中的access_token不同。
     * 公众号可通过下述接口来获取网页授权access_token。
     * 如果网页授权的作用域为snsapi_base，则本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
     * @param $code getCode()获取的code参数
     */
    public static function getAccessTokenAndOpenId($code){
        //公众号的唯一标识
        $appid = WECHAT_APPID;
        //公众号的appsecret
        $secret = WECHAT_APPSECRET;
        //填写为authorization_code
        $grant_type = 'authorization_code';
        //构造请求微信接口的URL
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type='.$grant_type.'';
        //请求微信接口, Array(access_token, expires_in, refresh_token, openid, scope)
        return Curl::callWebServer($url);
    }

    /**
     * Description: 获取用户信息 通过 - snsapi_base。即不弹出授权认证
     * @param $code getCode()获得，采用跳转方式，需要自行$_GET先获得
     * @param Array
     */
    public static function getUserInfoBySnsapiBase($code, $uri){
        //获取OpenId
        $openId = self::getAccessTokenAndOpenId($code);
        //如果code无效，则重新获取code
        if(isset($openId['errcode']) && $openId['errcode']=40029){
            WeChatOAuth::getCode($uri);
        }
        if(empty($openId['openid'])){
            die('获取微信授权失败，请回到微信界面重新进入！无效openid');
        }
        $openId = $openId['openid'];
        //根据OpenId获取用户信息
        return UserManage::getUserInfo($openId);
    }
}