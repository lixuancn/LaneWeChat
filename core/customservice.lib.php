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