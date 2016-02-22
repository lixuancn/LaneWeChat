<?php
namespace LaneWeChat\Core;
/**
 * 多客服功能
 * User: lane
 * Date: 14-10-31
 * Time: 上午10:30
 * E-mail: lixuan868686@163.com
 * WebSite: http://www.lanecn.com
 */
Class CustomService{
    /**
     * 客服帐号管理 - 添加客服帐号
     * 请注意，必须先在公众平台官网为公众号设置微信号后才能使用该能力。
     * 开发者可以通过本接口为公众号添加客服账号，每个公众号最多添加10个客服账号。
     *
     * @param $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
     * @param $nickname String 昵称
     * @param $password String 密码
     *
     * @return array( "errcode" : 0, "errmsg" : "ok")
     */
    public function addAccount($kfAccount, $nickname, $password){
        $queryUrl = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['kf_account'] = $kfAccount;
        $template['nickname'] = $nickname;
        $template['password'] = $password;
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 客服帐号管理 - 修改客服帐号
     * 请注意，必须先在公众平台官网为公众号设置微信号后才能使用该能力。
     *
     * @param $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
     * @param $nickname String 昵称
     * @param $password String 密码
     *
     * @return array( "errcode" : 0, "errmsg" : "ok")
     */
    public function editAccount($kfAccount, $nickname, $password){
        $queryUrl = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['kf_account'] = $kfAccount;
        $template['nickname'] = $nickname;
        $template['password'] = $password;
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 客服帐号管理 - 删除客服帐号
     * 请注意，必须先在公众平台官网为公众号设置微信号后才能使用该能力。
     *
     * @param $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
     * @param $nickname String 昵称
     * @param $password String 密码
     *
     * @return array( "errcode" : 0, "errmsg" : "ok")
     */
    public function delAccount($kfAccount, $nickname, $password){
        $queryUrl = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['kf_account'] = $kfAccount;
        $template['nickname'] = $nickname;
        $template['password'] = $password;
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 客服帐号管理 - 获取所有客服账号
     * 请注意，必须先在公众平台官网为公众号设置微信号后才能使用该能力。
     *
     * @param $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
     * @param $nickname String 昵称
     * @param $password String 密码
     *
     * @return array( "kf_list"=>array(
           array("kf_account": "test1@test", "kf_nick": "ntest1", "kf_id": "1001", "kf_headimgurl": " http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjfUS8Ym0GSaLic0FD3vN0V8PILcibEGb2fPfEOmw/0"),
     * ))
     */
    public function getAccountList($kfAccount, $nickname, $password){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token='.AccessToken::getAccessToken();
        $queryAction = 'GET';
        $template = array();
        $template['kf_account'] = $kfAccount;
        $template['nickname'] = $nickname;
        $template['password'] = $password;
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, $queryAction);
    }

    /**
     * 客服帐号管理 - 设置客服帐号的头像
     * 请注意，必须先在公众平台官网为公众号设置微信号后才能使用该能力。
     *
     * 可调用本接口来上传图片作为客服人员的头像，头像图片文件必须是jpg格式，推荐使用640*640大小的图片以达到最佳效果
     *
     * @param $kfAccount String 完整客服账号，格式为：账号前缀@公众号微信号
     * @param $imagePath String 待上传的头像文件路径
     *
     * @return array( "errcode" : 0, "errmsg" : "ok")
     */
    public function setAccountImage($kfAccount, $imagePath){
        if(!file_exists($imagePath)){
            return false;
        }
        //获取ACCESS_TOKEN
        $queryUrl = 'http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token='.AccessToken::getAccessToken().'&kf_account='.$kfAccount;
        $data = array();
        $data['media'] = Curl::addFile($imagePath);
        return Curl::callWebServer($queryUrl, $data, 'POST', 1 , 0);
    }

    /**
     * 获取客服聊天记录接口，有分页，一次获取一页，一页最多1000条
     * 在需要时，开发者可以通过获取客服聊天记录接口，获取多客服的会话记录，包括客服和用户会话的所有消息记录和会话的创建、关闭等操作记录。利用此接口可以开发如“消息记录”、“工作监控”、“客服绩效考核”等功能
     *
     * @param $startTime 查询开始时间，UNIX时间戳
     * @param $endTime 查询结束时间，UNIX时间戳，每次查询不能跨日查询
     * @param $pageIndex 查询第几页，从1开始
     * @param $pageSize	每页大小，每页最多拉取1000条
     * @param $openId 可以为空，普通用户的标识，对当前公众号唯一。
     *
     * @return array(
                    array("worker"=>"test1", "openid"=>"", "opercode"=>2002, "time"=>1400563710, "text"=>"您好，客服test1为您服务。"),
                    array("worker"=>"test1", "openid"=>"", "opercode"=>2002, "time"=>1400563715, "text"=>" 你好，有什么事情？"),
     * )
     * 关于opercode 1000 创建未接入会话，1001 接入会话，     1002 主动发起会话，1004 关闭会话
                   1005 抢接会话，     2001 公众号收到消息，2002 客服发送消息，2003 客服收到消息
     */
    public function getRecord($startTime, $endTime, $pageIndex=1, $pageSize=1000, $openId=''){
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/customservice/getrecord?access_token='.AccessToken::getAccessToken();
        $queryAction = 'POST';
        $template = array();
        $template['starttime'] = $startTime;
        $template['endtime'] = $endTime;
        $template['openid'] = $openId;
        $template['pagesize'] = $pageSize;
        $template['pageindex'] = $pageIndex;
        $template = json_encode($template);
        $result = Curl::callWebServer($queryUrl, $template, $queryAction);
        return isset($result['recordlist']) ? $result['recordlist'] : array();
    }
}