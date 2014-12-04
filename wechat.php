<?php
namespace LaneWeChat;

use LaneWeChat\Core\Wechat;

/**
 * 微信插件唯一入口文件.
 * @Created by Lane.
 * @Author: lane
 * @Mail lixuan868686@163.com
 * @Date: 14-1-10
 * @Time: 下午4:00
 * @Blog: Http://www.lanecn.com
 */
//引入配置文件
include_once __DIR__.'/config.php';
//引入自动载入函数
include_once __DIR__.'/autoloader.php';
//调用自动载入函数
AutoLoader::register();
//初始化微信类
$wechat = new WeChat(WECHAT_TOKEN, TRUE);

$valid_config = FALSE;   //首次使用需设置为TRUE，验证URL，验证成功后改回FALSE
if( $valid_config ){
    //验证URL
    $wechat->checkSignature();
}else{
    echo $wechat->run();
}
