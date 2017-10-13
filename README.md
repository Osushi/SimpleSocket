# SimpleSocket

Functions
---
+ Create socket client simply (Now support tcp only)
+ Able to write simple logic on closure after connection

Requirements
---
- PHP >= 7.0.*

Examples
---

See: https://github.com/Osushi/SimpleSocket/tree/master/samples/Connector.php

```
$connector = new \SimpleSocket\Connector();
$connector->connectTcp('google.com', 80)->then(function ($conn) {
  $conn->write("GET / HTTP/1.1\r\n\Host: google.com\r\n\r\n");
  
  var_dump($conn->read());
  /*
  string(519) "HTTP/1.1 302 Found
  ....
  </BODY></HTML>"
  */
  
  $conn->close();
});
```
