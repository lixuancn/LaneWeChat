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
include_once 'config.php';

$wechat = new WeChat(WECHAT_TOKEN, TRUE);
//首次使用需要注视掉下面这1行（21行），并打开最后一行（24行）
echo $wechat->run();

//首次使用需要打开下面这一行（24行），并且注释掉上面1行（21行）。本行用来验证URL
//$wechat->checkSignature();