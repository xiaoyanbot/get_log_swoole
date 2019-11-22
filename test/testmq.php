<?php
use TrytoMqtt\Client;
require_once __DIR__ . '/vendor/autoload.php';
$options = [
    'clean_session' => true,
    'client_id' => time(),
    'username' => '',
    'password' => '',
];
$mqtt = new Client('web.acyun.org', 1883, $options);
$mqtt->onConnect = function ($mqtt) {
    echo "conn OK !";
    $mqtt->publish('hello', 'hello swoole mqtt');
};
$mqtt->onError = function ($exception) {
    echo "error\n";
};
$mqtt->onClose = function () {
    echo "close\n";
};

$mqtt->connect();