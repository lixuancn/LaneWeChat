<?php
namespace LaneWeChat\Core;
/**
 * 素材管理 用来替换 多媒体的上传与下载
 * Created by Lane.
 * User: lane
 * Date: 14-8-11
 * Time: 上午9:51
 * E-mail: lixuan868686@163.com
 * WebSite: http://www.lanecn.com
 */
class Media{
    /**
     * 多媒体上传。上传图片、语音、视频等文件到微信服务器，上传后服务器会返回对应的media_id，公众号此后可根据该media_id来获取多媒体。
     * 上传的多媒体文件有格式和大小限制，如下：
     * 图片（image）: 1M，支持JPG格式
     * 语音（voice）：2M，播放长度不超过60s，支持AMR\MP3格式
     * 视频（video）：10MB，支持MP4格式
     * 缩略图（thumb）：64KB，支持JPG格式
     * 媒体文件在后台保存时间为3天，即3天后media_id失效。
     *
     * @param $filename，文件绝对路径
     * @param $type, 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
     * @return {"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
     */
    public static function upload($filename, $type){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$accessToken.'&type='.$type;
        $data = array();
        $data['media'] = Curl::addFile($filename);
        return Curl::callWebServer($queryUrl, $data, 'POST', 1 , 0);
    }

    /**
     * 获取永久素材
     * @param $mediaId 多媒体ID
     * @return
     * 返回说明 如果请求的素材为图文消息，则响应如下：
    {
    "news_item":
    [
    {
    "title":TITLE,
    "thumb_media_id"::THUMB_MEDIA_ID,
    "show_cover_pic":SHOW_COVER_PIC(0/1),
    "author":AUTHOR,
    "digest":DIGEST,
    "content":CONTENT,
    "url":URL,
    "content_source_url":CONTENT_SOURCE_URL
    },
    ]
    }
     * 如果返回的是视频消息素材，则内容如下：
    {
    "title":TITLE,
    "description":DESCRIPTION,
    "down_url":DOWN_URL,
    }
     * 其他类型的素材消息，则响应的直接为素材的内容，开发者可以自行保存为文件。例如：
    示例
    curl "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=ACCESS_TOKEN" -d '{"media_id":"61224425"}' > file

     *
     *
     */
    public static function download($mediaId){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$accessToken;
        $data = array();
        $data['media_id'] = $mediaId;
        return Curl::callWebServer($queryUrl, $data, 'POST', 0);
    }

    /**
     * 删除永久素材
     * @param $mediaId
     * @return {"errcode":ERRCODE,"errmsg":ERRMSG}
     */
    public static function delete($filename, $type){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token='.$accessToken;
        $data = array();
        $data['media'] = Curl::addFile($filename);
        return Curl::callWebServer($queryUrl, $data, 'POST', 1 , 0);
    }


    /**
     * 上传logo接口
     * @author: 正朴<2654035628@qq.com>
     * @param $filename 图片（image）绝对路径
     * @return Array ( [url] =>)
     */
    public static function uploadlogo($filename){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'http://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token='.$accessToken.'&type=image';
        $data = array();
        $data['media'] = Curl::addFile($filename);
        return Curl::callWebServer($queryUrl, $data, 'POST', 1 , 0);
    }
    /**
     * 获取素材的总数
     * @author: 正朴<2654035628@qq.com>
     * @return { "voice_count":COUNT,"video_count":COUNT,"image_count":COUNT,"news_count":COUNT}
     *
     */
    public static function getmaterialcount(){
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token='.$accessToken;
        return Curl::callWebServer($queryUrl, '', 'GET', 0);
    }
    /**
     * 获取素材列表
     * @author: 正朴<2654035628@qq.com>
     * @param $type 素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
     * @param $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
     * @param $count 返回素材的数量，取值在1到20之间
     */
    public static function getmateriallist($type,$offset,$count){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$accessToken;
        $template = array(
            'type'=>$type,
            'offset'=>$offset,
            'count'=>$count
        );
        $template = json_encode($template,JSON_UNESCAPED_UNICODE);
        return Curl::callWebServer($queryUrl, $template, 'POST', 1 , 0);
    }
}