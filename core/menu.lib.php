<?php
namespace LaneWeChat\Core;
/**
 * 自定义菜单
 * Created by PhpStorm.
 * User: lane
 * Date: 14-8-17
 * Time: 下午3:12
 * E-mail: lixuan868686@163.com
 * WebSite: http://www.lanecn.com
 */
class Menu{
    /**
     * 添加菜单，一级菜单最多3个，每个一级菜单最多可以有5个二级菜单
     * @param $menuList
     *          array(
     *              array('id'=>'', 'pid'=>'', 'name'=>'', 'type'=>'', 'code'=>''),
     *              array('id'=>'', 'pid'=>'', 'name'=>'', 'type'=>'', 'code'=>''),
     *              array('id'=>'', 'pid'=>'', 'name'=>'', 'type'=>'', 'code'=>''),
     *          );
     *          'code'是view类型的URL或者其他类型的key
     *          'type'是菜单类型，如下:
     *              1、click：点击推事件，用户点击click类型按钮后，微信服务器会通过消息接口推送消息类型为event的结构给开发者（参考消息接口指南），并且带上按钮中开发者填写的key值，开发者可以通过自定义的key值与用户进行交互；
     *              2、view：跳转URL，用户点击view类型按钮后，微信客户端将会打开开发者在按钮中填写的网页URL，可与网页授权获取用户基本信息接口结合，获得用户基本信息。
     *              3、scancode_push：扫码推事件，用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后显示扫描结果（如果是URL，将进入URL），且会将扫码的结果传给开发者，开发者可以下发消息。
     *              4、scancode_waitmsg：扫码推事件且弹出“消息接收中”提示框，用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后，将扫码的结果传给开发者，同时收起扫一扫工具，然后弹出“消息接收中”提示框，随后可能会收到开发者下发的消息。
     *              5、pic_sysphoto：弹出系统拍照发图，用户点击按钮后，微信客户端将调起系统相机，完成拍照操作后，会将拍摄的相片发送给开发者，并推送事件给开发者，同时收起系统相机，随后可能会收到开发者下发的消息。
     *              6、pic_photo_or_album：弹出拍照或者相册发图，用户点击按钮后，微信客户端将弹出选择器供用户选择“拍照”或者“从手机相册选择”。用户选择后即走其他两种流程。
     *              7、pic_weixin：弹出微信相册发图器，用户点击按钮后，微信客户端将调起微信相册，完成选择操作后，将选择的相片发送给开发者的服务器，并推送事件给开发者，同时收起相册，随后可能会收到开发者下发的消息。
     *              8、location_select：弹出地理位置选择器，用户点击按钮后，微信客户端将调起地理位置选择工具，完成选择操作后，将选择的地理位置发送给开发者的服务器，同时收起位置选择工具，随后可能会收到开发者下发的消息。
     *
     * @return bool
     */
    public static function setMenu($menuList){
        //树形排布
        $menuList2 = $menuList;
        foreach($menuList as $key=>$menu){
            foreach($menuList2 as $k=>$menu2){
                if($menu['id'] == $menu2['pid']){
                    $menuList[$key]['sub_button'][] = $menu2;
                    unset($menuList[$k]);
                }
            }
        }
        //处理数据
        foreach($menuList as $key=>$menu){
            //处理type和code
            if(@$menu['type'] == 'view'){
                $menuList[$key]['url'] = $menu['code'];
                //处理URL。因为URL不能在转换JSON时被转为UNICODE
                $menuList[$key]['url'] = urlencode($menuList[$key]['url']);
            }else if(@$menu['type'] == 'click'){
                $menuList[$key]['key'] = $menu['code'];
            }else if(@!empty($menu['type'])){
                $menuList[$key]['key'] = $menu['code'];
                if(!isset($menu['sub_button'])) $menuList[$key]['sub_button'] = array();
            }
            unset($menuList[$key]['code']);
            //处理PID和ID
            unset($menuList[$key]['id']);
            unset($menuList[$key]['pid']);
            //处理名字。因为汉字不能在转换JSON时被转为UNICODE
            $menuList[$key]['name'] = urlencode($menu['name']);
            //处理子类菜单
            if(isset($menu['sub_button'])){
                unset($menuList[$key]['type']);
                foreach($menu['sub_button'] as $k=>$son){
                    //处理type和code
                    if($son['type'] == 'view'){
                        $menuList[$key]['sub_button'][$k]['url'] = $son['code'];
                        $menuList[$key]['sub_button'][$k]['url'] = urlencode($menuList[$key]['sub_button'][$k]['url']);
                    }else if($son['type'] == 'click'){
                        $menuList[$key]['sub_button'][$k]['key'] = $son['code'];
                    }else{
                        $menuList[$key]['sub_button'][$k]['key'] = $son['code'];
                        $menuList[$key]['sub_button'][$k]['sub_button'] = array();
                    }
                    unset($menuList[$key]['sub_button'][$k]['code']);
                    //处理PID和ID
                    unset($menuList[$key]['sub_button'][$k]['id']);
                    unset($menuList[$key]['sub_button'][$k]['pid']);
                    //处理名字。因为汉字不能在转换JSON时被转为UNICODE
                    $menuList[$key]['sub_button'][$k]['name'] = urlencode($son['name']);
                }
            }
        }
        //整理格式
        $data = array();
        $menuList = array_values($menuList);
        $data['button'] = $menuList;
        //转换成JSON
        $data = json_encode($data);
        $data = urldecode($data);
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$accessToken;
        $result = Curl::callWebServer($url, $data, 'POST');
        if($result['errcode'] == 0){
            return true;
        }
        return $result;
    }

    /**
     * 获取微信菜单
     * @return bool|mixed
     *
     * 返回：{"menu":{"button":[{"type":"click","name":"今日歌曲","key":"V1001_TODAY_MUSIC","sub_button":[]},{"type":"click","name":"歌手简介","key":"V1001_TODAY_SINGER","sub_button":[]},{"name":"菜单","sub_button":[{"type":"view","name":"搜索","url":"http://www.soso.com/","sub_button":[]},{"type":"view","name":"视频","url":"http://v.qq.com/","sub_button":[]},{"type":"click","name":"赞一下我们","key":"V1001_GOOD","sub_button":[]}]}]}}
     */
    public static function getMenu(){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$accessToken;
        return Curl::callWebServer($url, '', 'GET');
    }

    /**
     * 获取微信菜单
     * @return bool|mixed
     *
     * 成功返回：{"errcode":0,"errmsg":"ok"}
     */
    public static function delMenu(){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$accessToken;
        return Curl::callWebServer($url, '', 'GET');
    }

    /**
     * 添加菜单，一级菜单最多3个，每个一级菜单最多可以有5个二级菜单
     * @param $menuListJson
     *        {
                "button":[
                {  
                    "type":"click",
                    "name":"今日歌曲",
                    "key":"V1001_TODAY_MUSIC"
                },
                {
                    "name":"菜单",
                    "sub_button":[
                    {    
                        "type":"view",
                        "name":"搜索",
                        "url":"http://www.soso.com/"
                    },
                    {
                        "type":"view",
                        "name":"视频",
                        "url":"http://v.qq.com/"
                    },
                    {
                        "type":"click",
                        "name":"赞一下我们",
                        "key":"V1001_GOOD"
                    }]
                }]
               }
     *各参数的说明同setMenu($menuList)方法

     * @return bool
     */
    
    public static function setMenuJson($menuListJson){
        //json格式
        $data=$menuListJson;
        //此处获得token所调用的函数内部有改写,此处是可在SAE平台上运行的,实际应用过程中可
        //根据运行平台的不同改写getAccessToken()函数
        $accessToken = AccessToken::getAccessToken();
        //创建默认菜单的请求地址
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$accessToken;
        $result = Curl::callWebServer($url, $data, 'POST');
        if($result['errcode'] == 0){
            return true;
        }
        return $result;
    }

    /**
     * 添加个性化菜单，一级菜单最多3个，每个一级菜单最多可以有5个二级菜单
     * @param $menuListJson
     *        {
                "button":[
                {   
                    "type":"click",
                    "name":"今日歌曲",
                    "key":"V1001_TODAY_MUSIC" 
                },
                { 
                    "name":"菜单",
                    "sub_button":[
                    {   
                        "type":"view",
                        "name":"搜索",
                        "url":"http://www.soso.com/"
                    },
                    {
                        "type":"view",
                        "name":"视频",
                        "url":"http://v.qq.com/"
                    },
                    {
                        "type":"click",
                        "name":"赞一下我们",
                        "key":"V1001_GOOD"
                    }]
                }],
                "matchrule":{
                "group_id":"2",
                "sex":"1",
                "country":"中国",
                "province":"广东",
                "city":"广州",
                "client_platform_type":"2"
                "language":"zh_CN"
                }
              }
     *除了匹配规则之中的参数,其余各参数的说明同setMenu($menuList)方法
     *关于匹配,只有符合匹配条件的用户才会有上述定制的个性化菜单
     * @return bool
     */
    public static function setPersonalMenuJson($menuListJson){
        //json格式
        $data=$menuListJson;
        //此处获得token所调用的函数内部有改写,此处是可在SAE平台上运行的,实际应用过程中可
        //根据运行平台的不同改写getAccessToken()函数
        $accessToken = AccessToken::getAccessToken();
        //请求地址与创建普通菜单有区别
        //创建个性化菜单之前必须先创建默认菜单
        $url = "https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=".$accessToken;
        $result = Curl::callWebServer($url, $data, 'POST');
        if($result['errcode'] == 0){
            return true;
        }
        return $result;
    }
}