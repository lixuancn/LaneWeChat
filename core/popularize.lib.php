<?php
namespace LaneWeChat\Core;
/**
 * 推广支持
 * User: lane
 * Date: 14-10-31
 * Time: 下午4:15
 * E-mail: lixuan868686@163.com
 * WebSite: http://www.lanecn.com
 */
class Popularize{
    /**
     * 生成带参数的二维码 - 第一步 创建二维码ticket
     *
     * 获取带参数的二维码的过程包括两步，首先创建二维码ticket，然后凭借ticket到指定URL换取二维码。
     *
     * 目前有2种类型的二维码，分别是临时二维码和永久二维码，
     * 前者有过期时间，最大为1800秒，但能够生成较多数量，后者无过期时间，数量较少（目前参数只支持1--100000）。
     * 两种二维码分别适用于帐号绑定、用户来源统计等场景。
     *
     * @param $type Int 临时二维码类型为1，永久二维码类型为2
     * @param $expireSeconds Int 过期时间，只在类型为临时二维码时有效。最大为1800，单位秒
     * @param $sceneId Int 场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）
     * @return Array(
     *      //获取的二维码ticket，凭借此ticket可以在有效时间内换取二维码。
     *      "ticket"=>"gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==",
     *      //二维码的有效时间，以秒为单位。最大不超过1800。
     *      "expire_seconds"=>60,
     *      //二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
     *      "url"=>"http://weixin.qq.com/q/kZgfwMTm72WWPkovabbI"
     * )
     */
    public static function createTicket($type, $expireSeconds, $sceneId){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        if($type == 1){
            $template['expire_seconds'] = $expireSeconds;
            $template['action_name'] = 'QR_SCENE';
        }else{
            $template['action_name'] = 'QR_LIMIT_SCENE';
        }
        $template['action_info']['scene']['scene_id'] = $sceneId;
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 生成带参数的二维码 - 第二步 通过ticket换取二维码
     * @param $ticket Popularize::createTicket()获得的
     * @param $filename String 文件路径，如果不为空，则会创建一个图片文件，二维码文件为jpg格式，保存到指定的路径
     * @return 直接echo本函数的返回值，并在调用页面添加header('Content-type: image/jpg');，将会展示出一个二维码的图片。
     */
    public static function getQrcode($ticket, $filename=''){
        $queryUrl = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket);
        $queryAction = 'GET';
        $result = Curl::callWebServer($queryUrl, '', $queryAction, 0);
        if(!empty($filename)){
            file_put_contents($filename, $result);
        }
        return $result;
    }

    /**
     * 将一条长链接转成短链接。
     * 主要使用场景：开发者用于生成二维码的原链接（商品、支付二维码等）太长导致扫码速度和成功率下降，将原长链接通过此接口转成短链接再生成二维码将大大提升扫码速度和成功率。
     * @param $longUrl String 需要转换的长链接，支持http://、https://、weixin://wxpay 格式的url
     * @return array('errcode'=>0, 'errmsg'=>'错误信息', 'short_url'=>'http://t.cn/asdasd')错误码为0表示正常
     */
    public static function long2short($longUrl){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/shorturl?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['long_url'] = $longUrl;
        $template['action'] = 'long2short';
        return Curl::callWebServer($queryUrl, '', $queryAction);
    }
}