<?php
$http = new swoole_http_server("127.0.0.1", 9501);
$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});
$http->on("request", function ($request, $response) {
    $info = $request->post['info'];
    echo $info . "\n";
    echo base64_decode( $info ) . "\n";
});
$http->start();