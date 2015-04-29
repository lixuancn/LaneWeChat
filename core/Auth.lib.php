<?php
namespace LaneWeChat\Core;
/**
 * Created by lixuan-it@360.cn
 * User: lane
 * Date: 15/4/29
 * Time: 上午10:51
 * E-mail: lixuan868686@163.com
 * WebSite: http://www.lanecn.com
 */
class Auth {
    /**
     * 获取微信服务器IP列表
     */
    public static function getWeChatIPList(){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token='.$accessToken;
        return Curl::callWebServer($url, '', 'GET');
    }
}