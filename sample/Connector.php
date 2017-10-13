<?php

require_once str_replace('/sample', '', __DIR__).'/vendor/autoload.php';

$connector = new \SimpleSocket\Connector();
$connector->connectTcp('google.com', 80)->then(function ($conn) {
  $conn->write("GET / HTTP/1.1\r\n\Host: google.com\r\n\r\n");
  var_dump($conn->read());
  $conn->close();
});
