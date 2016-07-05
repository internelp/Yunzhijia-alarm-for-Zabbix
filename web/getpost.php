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

function quit() {
    //返回消息
    Global $type;
    Global $responseArr;

    if ($type == "json"){
        print_r(json_encode($responseArr));
    } elseif ($type == "array") {
        print_r($responseArr);
    }
    exit;
}

/******处理POST信息*****/

//获取消息返回type
if (!empty($_GET["type"])) {
    // 定义返回的消息类型，json或数组，默认返回数组。
    $type = $_GET["type"];
} else {
    $type = "";
}

//获取企业注册号,不可空,空的话就退出.
if (!empty($_REQUEST["no"])) {
    //处理推送的消息内容
    $no = $_REQUEST["no"];
    $responseArr ['NO'] = $_REQUEST["no"];
} else {
    $responseArr ['NO'] = "企业号为空，请 POST \"no\" 内容！";
    quit();
}

//获取注册号pub,不可空,空的话就退出.
if (!empty($_REQUEST["pub"])) {
    //处理推送的消息内容
    $pub = $_REQUEST["pub"];
    $responseArr ['PUB'] = $_REQUEST["pub"];
} else {
    $responseArr ['PUB'] = "公众号pub为空，请 POST \"pub\" 内容！";
    quit();
}

//获取注册号pub,不可空,空的话就退出.
if (!empty($_REQUEST["pubkey"])) {
    //处理推送的消息内容
    $pubkey = $_REQUEST["pubkey"];
    $responseArr ['PUBKEY'] = "输入正确，输入内容隐藏。";
} else {
    $responseArr ['PUBKEY'] = "公众号pubkey为空，请 POST \"pubkey\" 内容！";
    quit();
}

//获取需要推送的消息内容,不允许空,空的话就退出.
if (!empty($_REQUEST["msg"])) {
    //处理推送的消息内容
    $msgArr = array('text' => $_REQUEST["msg"]."\r\n发送时间：".date("H:i:s"));
    $responseArr ['MESSAGE'] = $_REQUEST["msg"];
} else {
    $responseArr ['MESSAGE'] = "推送消息为空，请 POST \"msg\" 内容！";
    quit();
}

//生成接收人信息，默认将发给公众号的所有人
$userArr = array(
    array(
        'no' => $no,
        'code' => "all"
    )
);

?>