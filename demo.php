<?php
include 'lanewechat.php';
/**
 * 主动给用户发送信息
 */
//需要发给谁？
$tousername = "用户和公众号兑换的OpenId";
$mediaId = "通过上传多媒体文件，得到的id。";
//发送文本内容
\LaneWeChat\Core\ResponseInitiative::text($tousername, '文本消息内容');
//发送图片
\LaneWeChat\Core\ResponseInitiative::image($tousername, $mediaId);
//发送语音
\LaneWeChat\Core\ResponseInitiative::voice($tousername, $mediaId);
//发送视频
\LaneWeChat\Core\ResponseInitiative::video($tousername, $mediaId, '视频描述', '视频标题');
//发送地理位置
\LaneWeChat\Core\ResponseInitiative::music($tousername, '音乐标题', '音乐描述', '音乐链接', '高质量音乐链接，WIFI环境优先使用该链接播放音乐', '缩略图的媒体id，通过上传多媒体文件，得到的id');
//发送图文消息
//创建图文消息内容
$tuwenList[] = array('title'=>'标题1', 'description'=>'描述1', 'pic_url'=>'图片URL1', 'url'=>'点击跳转URL1');
$tuwenList[] = array('title'=>'标题2', 'description'=>'描述2', 'pic_url'=>'图片URL2', 'url'=>'点击跳转URL2');
//构建图文消息格式
$itemList = array();
foreach ($tuwenList as $tuwen) {
    $itemList[] = \LaneWeChat\Core\ResponseInitiative::newsItem($tuwen['title'], $tuwen['description'], $tuwen['pic_url'], $tuwen['url']);
}
\LaneWeChat\Core\ResponseInitiative::news($tousername, $itemList);


/**
 * 被动发送消息
 */
//需要发给谁？
$fromusername = "谁发给你的？（用户的openId）";
$tousername = "你的公众号Id";
$mediaId = "通过上传多媒体文件，得到的id。";
//发送文本
\LaneWeChat\Core\ResponsePassive::text($fromusername, $tousername, '文本消息内容');
//发送图片
\LaneWeChat\Core\ResponsePassive::image($fromusername, $tousername, $mediaId);
//发送语音
\LaneWeChat\Core\ResponsePassive::voice($fromusername, $tousername, $mediaId);
//发送视频
\LaneWeChat\Core\ResponsePassive::video($fromusername, $tousername, $mediaId, '视频标题', '视频描述');
//发送音乐
\LaneWeChat\Core\ResponsePassive::music($fromusername, $tousername, '音乐标题', '音乐描述', '音乐链接', '高质量音乐链接，WIFI环境优先使用该链接播放音乐', '缩略图的媒体id，通过上传多媒体文件，得到的id');
//发送图文
//创建图文消息内容
$tuwenList[] = array('title'=>'标题1', 'description'=>'描述1', 'pic_url'=>'图片URL1', 'url'=>'点击跳转URL1');
$tuwenList[] = array('title'=>'标题2', 'description'=>'描述2', 'pic_url'=>'图片URL2', 'url'=>'点击跳转URL2');
//构建图文消息格式
$itemList = array();
foreach($tuwenList as $tuwen){
    $itemList[] = \LaneWeChat\Core\ResponsePassive::newsItem($tuwen['title'], $tuwen['description'], $tuwen['pic_url'], $tuwen['url']);
}
\LaneWeChat\Core\ResponsePassive::news($fromusername, $tousername, $itemList);
//将消息转发到多客服
\LaneWeChat\Core\ResponsePassive::forwardToCustomService($fromusername, $tousername);

/**
 * 用户管理
 */
$openId = '用户和微信公众号的唯一ID';
//----分组管理----
//创建分组
\LaneWeChat\Core\UserManage::createGroup('分组名');
//获取分组列表
\LaneWeChat\Core\UserManage::getGroupList();
//查询用户所在分组
\LaneWeChat\Core\UserManage::getGroupByOpenId($openId);
//修改分组名
\LaneWeChat\Core\UserManage::editGroupName('分组Id', '新的组名');
//移动用户分组
\LaneWeChat\Core\UserManage::editUserGroup($openId, '新的分组ID');
//---用户管理----
//获取用户基本信息
\LaneWeChat\Core\UserManage::getUserInfo($openId);
//获取关注者列表
\LaneWeChat\Core\UserManage::getFansList($next_openId='');
//修改粉丝的备注
\LaneWeChat\Core\UserManage::setRemark($openId, '新昵称');
//获取网络状态
\LaneWeChat\Core\UserManage::getNetworkState();

/**
 * 网页授权
 */
/**
 * Description: 获取CODE
 * @param $scope snsapi_base不弹出授权页面，只能获得OpenId;snsapi_userinfo弹出授权页面，可以获得所有信息
 * 将会跳转到redirect_uri/?code=CODE&state=STATE 通过GET方式获取code和state
 */
$redirect_uri = '获取CODE时，发送请求和参数给微信服务器，微信服务器会处理后将跳转到本参数指定的URL页面';
\LaneWeChat\Core\WeChatOAuth::getCode($redirect_uri, $state=1, $scope='snsapi_base');
/**
 * Description: 通过code换取网页授权access_token
 * 首先请注意，这里通过code换取的网页授权access_token,与基础支持中的access_token不同。
 * 公众号可通过下述接口来获取网页授权access_token。
 * 如果网页授权的作用域为snsapi_base，则本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
 * @param $code getCode()获取的code参数
 */
$code = $_GET['code'];
\LaneWeChat\Core\WeChatOAuth::getAccessTokenAndOpenId($code);

//上传多媒体
\LaneWeChat\Core\Media::upload($filename, $type);
//下载多媒体
\LaneWeChat\Core\Media::download($mediaId);


/**
 * 自定义菜单
 */
//设置菜单
$menuList = array(
    array('id'=>'1', 'pid'=>'',  'name'=>'常规', 'type'=>'', 'code'=>'key_1'),
    array('id'=>'2', 'pid'=>'1',  'name'=>'点击', 'type'=>'click', 'code'=>'key_2'),
    array('id'=>'3', 'pid'=>'1',  'name'=>'浏览', 'type'=>'view', 'code'=>'http://www.lanecn.com'),
    array('id'=>'4', 'pid'=>'',  'name'=>'扫码', 'type'=>'', 'code'=>'key_4'),
    array('id'=>'5', 'pid'=>'4', 'name'=>'扫码带提示', 'type'=>'scancode_waitmsg', 'code'=>'key_5'),
    array('id'=>'6', 'pid'=>'4', 'name'=>'扫码推事件', 'type'=>'scancode_push', 'code'=>'key_6'),
    array('id'=>'7', 'pid'=>'',  'name'=>'发图', 'type'=>'', 'code'=>'key_7'),
    array('id'=>'8', 'pid'=>'7', 'name'=>'系统拍照发图', 'type'=>'pic_sysphoto', 'code'=>'key_8'),
    array('id'=>'9', 'pid'=>'7', 'name'=>'拍照或者相册发图', 'type'=>'pic_photo_or_album', 'code'=>'key_9'),
    array('id'=>'10', 'pid'=>'7', 'name'=>'微信相册发图', 'type'=>'pic_weixin', 'code'=>'key_10'),
    array('id'=>'11', 'pid'=>'1', 'name'=>'发送位置', 'type'=>'location_select', 'code'=>'key_11'),
);
\LaneWeChat\Core\Menu::setMenu($menuList);
//获取菜单
\LaneWeChat\Core\Menu::getMenu();
//删除菜单
\LaneWeChat\Core\Menu::delMenu();


/**
 * 应用一：给粉丝群发发送消息
 */
//群发消息
//获取粉丝列表
$fansList = \LaneWeChat\Core\UserManage::getFansList();
//上传图片
$menuId = \LaneWeChat\Core\Media::upload('/var/www/baidu_jgylogo3.jpg', 'image');
if (empty($menuId['media_id'])) {
    die('error');
}
//上传图文消息
$list = array();
$list[] = array('thumb_media_id'=>$menuId['media_id'] , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'1');
$list[] = array('thumb_media_id'=>$menuId['media_id'] , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'0');
$list[] = array('thumb_media_id'=>$menuId['media_id'] , 'author'=>'作者', 'title'=>'标题', 'content_source_url'=>'www.lanecn.com', 'digest'=>'摘要', 'show_cover_pic'=>'0');
$mediaId = \LaneWeChat\Core\AdvancedBroadcast::uploadNews($list);
//给粉丝列表的用户群发图文消息
$result = \LaneWeChat\Core\AdvancedBroadcast::sentNewsByOpenId($fansList['data']['openid'], $mediaId);