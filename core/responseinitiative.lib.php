<?php
namespace LaneWeChat\Core;
/**
 * 发送主动响应
 * Created by Lane.
 * User: lane
 * Date: 13-12-29
 * Time: 下午5:54
 * Mail: lixuan868686@163.com
 * Website: http://www.lanecn.com
 */
class ResponseInitiative{

    protected static $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=';

    protected static $action = 'POST';

    /**
     * @descrpition 文本
     * @param $tousername
     * @param $content 回复的消息内容（换行：在content中能够换行，微信客户端就支持换行显示）
     * @return string
     */
    public static function text($tousername, $content){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();

        //开始
        $template = array(
            'touser'=>$tousername,
            'msgtype'=>'text',
            'text'=>array(
                'content'=>$content,
            ),
        );
        $template = json_encode($template);

        return Curl::callWebServer(self::$queryUrl.$accessToken, $template, self::$action);
    }

    /**
     * @descrpition 图片
     * @param $tousername
     * @param $mediaId 通过上传多媒体文件，得到的id。
     * @return string
     */
    public static function image($tousername, $mediaId){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();

        //开始
        $template = array(
            'touser'=>$tousername,
            'msgtype'=>'image',
            'image'=>array(
                'media_id'=>$mediaId,
            ),
        );
        $template = json_encode($template);
        return Curl::callWebServer(self::$queryUrl.$accessToken, $template, self::$action);
    }

    /**
     * @descrpition 语音
     * @param $tousername
     * @param $mediaId 通过上传多媒体文件，得到的id
     * @return string
     */
    public static function voice($tousername, $mediaId){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();

        //开始
        $template = array(
            'touser'=>$tousername,
            'msgtype'=>'voice',
            'voice'=>array(
                'media_id'=>$mediaId,
            ),
        );
        $template = json_encode($template);
        return Curl::callWebServer(self::$queryUrl.$accessToken, $template, self::$action);
    }

    /**
     * @descrpition 视频
     * @param $tousername
     * @param $mediaId 通过上传多媒体文件，得到的id
     * @param $title 标题
     * @param $description 描述
     * @return string
     */
    public static function video($tousername, $mediaId, $title, $description){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();

        //开始
        $template = array(
            'touser'=>$tousername,
            'msgtype'=>'video',
            'video'=>array(
                'media_id'=>$mediaId,
                'title'=>$title,
                'description'=>$description,
            ),
        );
        $template = json_encode($template);
        return Curl::callWebServer(self::$queryUrl.$accessToken, $template, self::$action);
    }

    /**
     * @descrpition 音乐
     * @param $tousername
     * @param $title 标题
     * @param $description 描述
     * @param $musicUrl 音乐链接
     * @param $hqMusicUrl 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @param $thumbMediaId 缩略图的媒体id，通过上传多媒体文件，得到的id
     * @return string
     */
    public static function music($tousername, $title, $description, $musicUrl, $hqMusicUrl, $thumbMediaId){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();

        //开始
        $template = array(
            'touser'=>$tousername,
            'msgtype'=>'music',
            'music'=>array(
                'title'=>$title,
                'description'=>$description,
                'musicurl'=>$musicUrl,
                'hqmusicurl'=>$hqMusicUrl,
                'thumb_media_id'=>$thumbMediaId,
            ),
        );
        $template = json_encode($template);
        return Curl::callWebServer(self::$queryUrl.$accessToken, $template, self::$action);
    }

    /**
     * @descrpition 图文消息 - 单个项目的准备工作，用于内嵌到self::news()中。现调用本方法，再调用self::news()
     *              多条图文消息信息，默认第一个item为大图,注意，如果调用本方法得到的数组总项数超过10，则将会无响应
     * @param $title 标题
     * @param $description 描述
     * @param $picUrl 图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200
     * @param $url 点击图文消息跳转链接
     * @return string
     */
    public static function newsItem($title, $description, $picUrl, $url){
        return $template = array(
            'title'=>$title,
            'description'=>$description,
            'url'=>$url,
            'picurl'=>$picUrl,
        );
    }

    /**
     * @descrpition 图文 - 先调用self::newsItem()再调用本方法
     * @param $tousername
     * @param $item 数组，每个项由self::newsItem()返回
     * @return string
     */
    public static function news($tousername, $item){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();

        //开始
        $template = array(
            'touser'=>$tousername,
            'msgtype'=>'news',
            'news'=>array(
                'articles'=>$item
            ),
        );
        $template = json_encode($template);
        return Curl::callWebServer(self::$queryUrl.$accessToken, $template, self::$action);
    }


}