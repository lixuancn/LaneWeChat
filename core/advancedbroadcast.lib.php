<?php
namespace LaneWeChat\Core;
/**
 * 高级群发接口
 * User: lane
 * Date: 14-10-27
 * Time: 下午7:24
 * E-mail: lixuan868686@163.com
 * WebSite: http://www.lanecn.com
 */
class AdvancedBroadcast{

    /**
     * 上传图文消息素材 - 创建一个图文消息，保存到微信服务器，可以得到一个id代表这个图文消息，发送的时候根据这个id发送就可以了
     *
     * @param $articles = array(
                            array('thumb_media_id'=>'多媒体ID，由多媒体上传接口获得' , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'是否设置为封面（0或者1）'),
                            array('thumb_media_id'=>'多媒体ID，由多媒体上传接口获得' , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'是否设置为封面（0或者1）'),
     *                  )
     *
     * return mediaId 上传的图文消息的ID
     */
    public static function uploadNews($articles){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        foreach($articles as &$article){
            $article['author'] = urlencode($article['author']);
            $article['title'] = urlencode($article['title']);
            $article['digest'] = urlencode($article['digest']);
        }
        $template = array();
        $template['articles'] = $articles;
        $template = json_encode($template);
        $template = urldecode($template);
        $result = Curl::callWebServer($queryUrl, $template, $queryAction);
        if(empty($result['type']) || $result['type'] != 'news' || empty($result['media_id'])){
            return false;
        }
        return $result['media_id'];
    }

    /**
     * 根据分组进行群发 - 发送图文消息
     *
     * @param $groupId 要发送的分组ID
     * @param $mediaId 必须通过self::uploadNews获得的多媒体资源ID
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentNewsByGroup($groupId, $mediaId){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['filter']['group_id'] = $groupId;
        $template['mpnews']['media_id'] = $mediaId;
        $template['msgtype'] = 'mpnews';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据分组进行群发 - 发送文本消息
     *
     * @param $groupId 要发送的分组ID
     * @param $content 文本消息的内容
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentTextByGroup($groupId, $content){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['filter']['group_id'] = $groupId;
        $template['text']['content'] = $content;
        $template['msgtype'] = 'text';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据分组进行群发 - 发送语音消息
     *
     * @param $groupId 要发送的分组ID
     * @param $mediaId 需通过基础支持中的上传下载多媒体文件来得到。Media::upload()中返回的media_id字段的值
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentVoiceByGroup($groupId, $mediaId){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['filter']['group_id'] = $groupId;
        $template['voice']['media_id'] = $mediaId;
        $template['msgtype'] = 'voice';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据分组进行群发 - 发送图片消息
     *
     * @param $groupId 要发送的分组ID
     * @param $mediaId 需通过基础支持中的上传下载多媒体文件来得到。Media::upload()中返回的media_id字段的值
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentImageByGroup($groupId, $mediaId){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['filter']['group_id'] = $groupId;
        $template['image']['media_id'] = $mediaId;
        $template['msgtype'] = 'image';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据分组进行群发 - 发送视频消息
     *
     * @param $groupId 要发送的分组ID
     * @param $mediaId 需通过基础支持中的上传下载多媒体文件来得到。Media::upload()中返回的media_id字段的值
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentVideoByGroup($mediaId, $title, $description, $groupId){
        //将根据基础支持中上传多媒体得到的mediaId转化为群发视频消息所需要的mediaId。
        $queryUrl = 'https://file.api.weixin.qq.com/cgi-bin/media/uploadvideo?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['media_id'] = $mediaId;
        $template['title'] = $title;
        $template['description'] = $description;
        $template = json_encode($template);
        $result = Curl::callWebServer($queryUrl, $template, $queryAction);
        if(empty($result['type']) || $result['type'] != 'video' || empty($result['media_id'])){
            return $result;
        }
        $mediaId = $result['media_id'];
        //群发视频
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['filter']['group_id'] = $groupId;
        $template['mpvideo']['media_id'] = $mediaId;
        $template['msgtype'] = 'mpvideo';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据OpenID列表群发 - 发送图文消息
     *
     * @param $toUserList array(openId1, openId2, openId3)
     * @param $mediaId 需通过基础支持中的上传下载多媒体文件来得到。Media::upload()中返回的media_id字段的值
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentNewsByOpenId($toUserList, $mediaId){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['touser'] = $toUserList;
        $template['mpnews']['media_id'] = $mediaId;
        $template['msgtype'] = 'mpnews';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据OpenID列表群发 - 发送文本消息
     *
     * @param $toUserList array(openId1, openId2, openId3)
     * @param $content 文本消息的内容
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentTextByOpenId($toUserList, $content){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['touser'] = $toUserList;
        $template['text']['content'] = $content;
        $template['msgtype'] = 'text';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据OpenID列表群发 - 发送语音消息
     *
     * @param $toUserList array(openId1, openId2, openId3)
     * @param $mediaId 需通过基础支持中的上传下载多媒体文件来得到。Media::upload()中返回的media_id字段的值
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentVoiceByOpenId($toUserList, $mediaId){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['touser'] = $toUserList;
        $template['voice']['media_id'] = $mediaId;
        $template['msgtype'] = 'voice';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据OpenID列表群发 - 发送图片消息
     *
     * @param $toUserList array(openId1, openId2, openId3)
     * @param $mediaId 需通过基础支持中的上传下载多媒体文件来得到。Media::upload()中返回的media_id字段的值
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentImageByOpenId($toUserList, $mediaId){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['touser'] = $toUserList;
        $template['image']['media_id'] = $mediaId;
        $template['msgtype'] = 'image';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 根据OpenID列表群发 - 发送视频消息
     *
     * @param $toUserList array(openId1, openId2, openId3)
     * @param $mediaId 需通过基础支持中的上传下载多媒体文件来得到。Media::upload()中返回的media_id字段的值
     * @return mixed array("errcode"=>0, "errmsg"=>"success","msg_id"=>34182} 正常是errcode为0
     */
    public static function sentVideoByOpenId($toUserList, $mediaId, $title, $description){
        //将根据基础支持中上传多媒体得到的mediaId转化为群发视频消息所需要的mediaId。
        $queryUrl = 'https://file.api.weixin.qq.com/cgi-bin/media/uploadvideo?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['media_id'] = $mediaId;
        $template['title'] = $title;
        $template['description'] = $description;
        $template = json_encode($template);
        $result = Curl::callWebServer($queryUrl, $template, $queryAction);
        if(empty($result['type']) || $result['type'] != 'video' || empty($result['media_id'])){
            return $result;
        }
        $mediaId = $result['media_id'];
        //群发视频
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['touser'] = $toUserList;
        $template['video']['media_id'] = $mediaId;
        $template['video']['title'] = $title;
        $template['video']['description'] = $description;
        $template['msgtype'] = 'video';
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 删除群发
     * 请注意，只有已经发送成功的消息才能删除删除消息只是将消息的图文详情页失效，已经收到的用户，还是能在其本地看到消息卡片。 另外，删除群发消息只能删除图文消息和视频消息，其他类型的消息一经发送，无法删除。
     *
     * @param $msgId 发送出去的消息ID
     * @return mixed array("errcode"=>0, "errmsg"=>"ok"} 正常是errcode为0
     */
    public static function delete($msgId){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['msg_id'] = $msgId;
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }
}