<?php
use TrytoMqtt\Client;
require_once __DIR__ . '/vendor/autoload.php';

/**
 * 对 HTTP Server 进行设置
 */
$http = new swoole_http_server("127.0.0.1", 9501);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request", function ($request, $response) {
    $info = $request->post['info'];
    //echo $info . "\n";
    // 接收到日志的时候，先打印出来
    $oinfo = base64_decode( $info );
    echo  $oinfo. "\n";

    /**
     * MQTT 客户端连接
     */
    $options = [
        'clean_session' => true,
        'client_id' => time(),
        'username' => '',
        'password' => '',
    ];
    $mqtt = new Client('web.acyun.org', 1883, $options);
    $mqtt->onConnect = function ($mqtt,$oinfo) {
        echo "conn OK !";
        $mqtt->publish('hello', $oinfo);
    };
    $mqtt->onError = function ($exception) {
        echo "error\n";
    };
    $mqtt->onClose = function () {
        echo "close\n";
    };

    $mqtt->connect();

    // 然后进行HTTP的发送
    if($mqtt->isConnected()){
        $mqtt->publish('hello', 'hello swoole mqtt');
    }

    $mqtt->close();

});

$http->start();