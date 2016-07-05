<?php

/******************************
    云之家报警接口程序 -- init
    -- 将所有消息转发给云之家
    版本：1.0
    创建：枫叶
    支持：千思网（http://www.qiansw.com）
    创建：2015-03-20
    修改：2015-08-03
    使用说明：post内容到本地址。
            "msg" 为文本消息内容（不可空）；
            "no"  为公众号企业注册号（不可空）；
            "pub" 为接收方公众号（不可空）；
            "pubkey" 为公众号密钥（不可空）；
            "type" 为消息返回类型，可空，get方式，"array"时返回数组，为"json"时返回json格式文本，不符合上述时不返回。
            发送消息的格式为POST以上信息到：http://servername/init.php?type=json
******************************/
header("Content-type: application/json; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');
#echo $showtime=date("Y-m-d H:i:s");
$responseArr = array('说明' => "本数组包含各项返回消息", );             //初始化返回消息数组

include "./getpost.php";
include "./config.php";
include "./function.php";


$data=(makeData($userArr,makeFrom(getPubToken($pubtokenArr),$pubtokenArr),2,$msgArr));
$data_string = json_encode($data);
// print_r($data_string);
// exit;
list($return_code, $return_content) = http_post_data($url, $data_string);
$responseArr ['STATUS'] = $return_code;
$responseArr ['RESPONSE'] = $return_content;
quit();

?>
