<?php
namespace LaneWeChat;

use LaneWeChat\Core\AccessToken;
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
include_once 'config.php';

AccessToken::test();
exit;
/**
 * @descrpition 微信请求处理
 */
$obj = new WeChat(TOKEN, TRUE);
echo $obj->run();
//验证URL
//App::checkSignature();
