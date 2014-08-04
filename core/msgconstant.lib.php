<?php
namespace LaneWeChat\Core;
/**
 * 错误码常量
 * Created by Lane.
 * @Class MsgConstant
 * @Author: lane
 * @Mail lixuan868686@163.com
 * @Date: 14-1-10
 * @Time: 下午4:22
 */
class MsgConstant{

    //-------系统错误相关--101 到200 ------
    const ERROR_SYSTEM = 101; //系统错误
    const ERROR_NEWS_ITEM_COUNT_MORE_TEN = 102; //图文消息的项数超过10
    const ERROR_MENU_CLICK = 103; //微信这个坑爹货，菜单跳转失败，请重试。
    

    //-------用户输入相关--1001到1100------
    const ERROR_INPUT_ERROR = 1001; //输入有误，请重新输入
    const ERROR_UNKNOW_TYPE = 1002; //收到了未知类型的消息
    const ERROR_CAPTCHA_ERROR = 1003; //验证码错误
    const ERROR_REQUIRED_FIELDS = 1004; //必填项未填写全

    //-------远程调用相关--1201到1300------
    const ERROR_REMOTE_SERVER_NOT_RESPOND = 1201; //远程服务器未响应
    const ERROR_GET_ACCESS_TOKEN = 1202; //获取ACCESS_TOKEN失败

    //-------文章管理相关--1301到1400------

    //-------分类管理相关--1401到1500------
    const ERROR_MENU_NOT_EXISTS = 1401; //菜单不存在

    //-------文案类-----------------------
    const ERROR_NO_BINDING_TEXT = '对不起，您尚未绑定微信，轻松绑定微信，即可查询实时流量，享受便捷服务!'; //未绑定微信时错误文案
}