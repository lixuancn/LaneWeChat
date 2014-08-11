<?php
namespace LaneWeChat;

/**
 * 主动给用户发送信息
 */
//命名空间
use LaneWeChat\Core\ResponseInitiative;
//需要发给谁？
$tousername = "用户和公众号兑换的OpenId";
$mediaId = "通过上传多媒体文件，得到的id。";
//发送文本内容
ResponseInitiative::text($tousername, '文本消息内容');
//发送图片
ResponseInitiative::image($tousername, $mediaId);
//发送语音
ResponseInitiative::voice($tousername, $mediaId);
//发送视频
ResponseInitiative::video($tousername, $mediaId, '视频描述', '视频标题');
//发送地理位置
ResponseInitiative::music($tousername, '音乐标题', '音乐描述', '音乐链接', '高质量音乐链接，WIFI环境优先使用该链接播放音乐', '缩略图的媒体id，通过上传多媒体文件，得到的id');
//发送图文消息
//创建图文消息内容
$tuwenList[] = array('title'=>'标题1', 'description'=>'描述1', 'pic_url'=>'图片URL1', 'url'=>'点击跳转URL1');
$tuwenList[] = array('title'=>'标题2', 'description'=>'描述2', 'pic_url'=>'图片URL2', 'url'=>'点击跳转URL2');
//构建图文消息格式
$itemList = array();
foreach($tuwenList as $tuwen){
    $itemList[] = ResponseInitiative::newsItem($tuwen['title'], $tuwen['description'], $tuwen['pic_url'], $tuwen['url']);
}
ResponseInitiative::news($tousername, $itemList);


/**
 * 被动发送消息
 */
//命名空间
use LaneWeChat\Core\ResponsePassive;
//需要发给谁？
$fromusername = "谁发给你的？（用户的openId）";
$tousername = "你的公众号Id";
$mediaId = "通过上传多媒体文件，得到的id。";
//发送文本
ResponsePassive::text($fromusername, $tousername, '文本消息内容');
//发送图片
ResponsePassive::image($fromusername, $tousername, $mediaId);
//发送语音
ResponsePassive::voice($fromusername, $tousername, $mediaId);
//发送视频
ResponsePassive::video($fromusername, $tousername, $mediaId, '视频标题', '视频描述');
//发送音乐
ResponsePassive::music($fromusername, $tousername, '音乐标题', '音乐描述', '音乐链接', '高质量音乐链接，WIFI环境优先使用该链接播放音乐', '缩略图的媒体id，通过上传多媒体文件，得到的id');
//发送图文
//创建图文消息内容
$tuwenList[] = array('title'=>'标题1', 'description'=>'描述1', 'pic_url'=>'图片URL1', 'url'=>'点击跳转URL1');
$tuwenList[] = array('title'=>'标题2', 'description'=>'描述2', 'pic_url'=>'图片URL2', 'url'=>'点击跳转URL2');
//构建图文消息格式
$itemList = array();
foreach($tuwenList as $tuwen){
    $itemList[] = ResponsePassive::newsItem($tuwen['title'], $tuwen['description'], $tuwen['pic_url'], $tuwen['url']);
}
ResponsePassive::news($fromusername, $tousername, $itemList);


/**
 * 用户管理
 */
//命名空间
use LaneWeChat\Core\UserManage;
$openId = '用户和微信公众号的唯一ID';
//----分组管理----
//创建分组
UserManage::createGroup('分组名');
//获取分组列表
UserManage::getGroupList();
//查询用户所在分组
UserManage::getGroupByOpenId($openId);
//修改分组名
UserManage::editGroupName('分组Id', '新的组名');
//移动用户分组
UserManage::editUserGroup($openId, '新的分组ID');
//---用户管理----
//获取用户基本信息
UserManage::getUserInfo($openId);
//获取关注者列表
UserManage::getFansList($next_openId='');
//获取网络状态
UserManage::getNetworkState();

/**
 * 网页授权
 */
//命名空间
use LaneWeChat\Core\WeChatOAuth;
/**
 * Description: 获取CODE
 * @param $scope snsapi_base不弹出授权页面，只能获得OpenId;snsapi_userinfo弹出授权页面，可以获得所有信息
 * 将会跳转到redirect_uri/?code=CODE&state=STATE 通过GET方式获取code和state
 */
$redirect_uri = '获取CODE时，发送请求和参数给微信服务器，微信服务器会处理后将跳转到本参数指定的URL页面';
WeChatOAuth::getCode($redirect_uri, $state=1, $scope='snsapi_base');
/**
 * Description: 通过code换取网页授权access_token
 * 首先请注意，这里通过code换取的网页授权access_token,与基础支持中的access_token不同。
 * 公众号可通过下述接口来获取网页授权access_token。
 * 如果网页授权的作用域为snsapi_base，则本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
 * @param $code getCode()获取的code参数
 */
$code = $_GET['code'];
WeChatOAuth::getAccessTokenAndOpenId($code);

/**
 * Description: 获取用户信息 通过 - snsapi_base。即不弹出授权认证
 * @param $code getCode()获得，采用跳转方式，需要自行$_GET先获得
 */
$code = $_GET['code'];
WeChatOAuth::getUserInfoBySnsapiBase($code, $redirect_uri='CODE不存在时需要传给getCode()的参数中的$redirect_uri');

//上传多媒体
Media::upload($filename, $type);
//下载多媒体
Media::download($mediaId);
