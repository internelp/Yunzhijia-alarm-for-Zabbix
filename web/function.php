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

function getPubToken($pubtokenArr) {
    //处理公共号密钥验证规则pubtoken=sha(no,pub,公共号.密钥pubkey,nonce,time)
    
    $a = $pubtokenArr;
    sort($a,SORT_STRING); 
    $b = implode("",$a);
    $pubtoken = sha1($b);
    return $pubtoken;
}

function makeFrom($pubtoken,$pubtokenArr) {
    //定义消息发送人信息，格式为JSON对象。

    $fromArr = array(
        'no'        =>  $pubtokenArr[0],
        'pub'       =>  $pubtokenArr[1],
        'time'      =>  $pubtokenArr[4],
        'nonce'     =>  $pubtokenArr[3],
        'pubtoken'  =>  $pubtoken
    );
    return $fromArr;
}

function makeData($toArr,$from,$type,$msg) {
    //处理要POST的信息，格式为JSON对象。

    $dataArr = array(
        'from'      =>  $from,
        'to'        =>  $toArr,
        'type'      =>  $type,
        'msg'       =>  $msg
    );
    return $dataArr;
}

function http_post_data($url, $data_string) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Content-Length: ' . strlen($data_string))
    );
    ob_start();
    curl_exec($ch);
    $return_content = ob_get_contents();
    ob_end_clean();

    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return array($return_code, $return_content);
}



?>