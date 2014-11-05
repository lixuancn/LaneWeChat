注意事项：
1.WXBizMsgCrypt.php文件提供了WXBizMsgCrypt类的实现，是用户接入企业微信的接口类。Sample.php提供了示例以供开发者参考。errorCode.php, pkcs7Encoder.php, sha1.php, xmlparse.php文件是实现这个类的辅助类，开发者无须关心其具体实现。
2.WXBizMsgCrypt类封装了 DecryptMsg, EncryptMsg两个接口，分别用于开发者解密以及开发者回复消息的加密。使用方法可以参考Sample.php文件。
3.加解密协议请参考微信公众平台官方文档。