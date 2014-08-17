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
                    array('id'=>'', 'pid'=>'', 'name'=>'', 'type'=>'', 'code'=>),
                    array('id'=>'', 'pid'=>'', 'name'=>'', 'type'=>'', 'code'=>),
                    array('id'=>'', 'pid'=>'', 'name'=>'', 'type'=>'', 'code'=>),
     *          );
     *          'type'是菜单类型，数字1或者2，1是view类型，2是click类型
     *          'code'是view类型的URL或者click类型的key
     *
     * @return bool
     */
    public function setMenu($menuList){
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
        $typeView = 1;
        $typeClick = 2;
        //处理数据
        foreach($menuList as $key=>$menu){
            //处理type和code
            if($menu['type'] == $typeView){
                $menuList[$key]['type'] = 'view';
                $menuList[$key]['url'] = $menu['code'];
                //处理URL。因为URL不能在转换JSON时被转为UNICODE
                $menuList[$key]['url'] = urlencode($menuList[$key]['url']);
            }else if($menu['type'] == $typeClick){
                $menuList[$key]['type'] = 'click';
                $menuList[$key]['key'] = $menu['code'];
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
                    if($son['type'] == $typeView){
                        $menuList[$key]['sub_button'][$k]['type'] = 'view';
                        $menuList[$key]['sub_button'][$k]['url'] = $son['code'];
                        $menuList[$key]['sub_button'][$k]['url'] = urlencode($menuList[$key]['sub_button'][$k]['url']);
                    }else if($son['type'] == $typeClick){
                        $menuList[$key]['sub_button'][$k]['type'] = 'click';
                        $menuList[$key]['sub_button'][$k]['key'] = $son['code'];
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
        return false;
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
}