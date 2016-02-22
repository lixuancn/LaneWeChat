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
        //检测本地是否已经拥有access_token，并且检测access_token是否过期
        $accessToken = self::_checkAccessToken();
        if($accessToken === false){
            $accessToken = self::_getAccessToken();
        }
        return $accessToken['access_token'];
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