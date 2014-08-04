<?php
namespace LaneWeChat\Core;
/**
 *
 * 错误提示类
 *
 * Class Msg
 * Created by Lane.
 * @Author: lane
 * @Mail: lixuan868686@163.com
 * @Date: 14-1-10
 * @Time: 下午4:22
 * Mail: lixuan868686@163.com
 * Website: http://www.lanecn.com
 */
class Msg {
	/**
	 * 返回错误信息 ...
	 * @param int $code 错误码
	 * @param string $errorMsg 错误信息
	 * @return Ambigous <multitype:unknown , multitype:, boolean>
	 */
	public static function returnErrMsg($code,  $errorMsg = null) {
		$returnMsg = array('error_code' => $code);
		if (!empty($errorMsg)) {
			$returnMsg['custom_msg'] = $errorMsg;
		}
        $returnMsg['custom_msg'] = '出错啦！'.$returnMsg['custom_msg'];
        exit($returnMsg['custom_msg']);
	}
}
?>
