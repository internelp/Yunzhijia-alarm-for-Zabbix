<?php

/******************************
    云之家报警接口程序
    -- 将所有消息转发给云之家
    版本：1.0
    创建：枫叶
    支持：千思网（http://www.qiansw.com）
    创建：2015-03-20
    修改：2015-08-03
******************************/

$url = "http://im.kdweibo.com/pubacc/pubsend";                      //金蝶接口地址
$nonce = rand(1111111111,9999999999)."a";                           //随机数字符串
$timestamp = time()."";                                             //当前时间戳
$pubtokenArr = array($no,$pub,$pubkey,$nonce,$timestamp);           //公共号密钥验证规则pubtoken=sha(no,pub,公共号.密钥pubkey,nonce,time)

?>
