<?php

class ConnectorTest extends \PHPUnit\Framework\TestCase
{
  public function testInstance()
  {
    $connector = new \SimpleSocket\Connector();
    $this->assertInstanceOf('\SimpleSocket\Connector', $connector);
  }

  public function testConnectTcpWithUnknonHost()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $connector->connectTcp('0.0.0.0', 22, 100);
      $this->fail('Unable to occur error exception');
    } catch (\Exception $e) {
      $this->assertEquals(10, $e->getCode());
    }
  }

  public function testAccessReadMethodWithoutConnection()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $connector->read();
      $this->fail('Unable to occur error exception');
    } catch (\Exception $e) {
      $this->assertEquals(20, $e->getCode());
    }
  }

  public function testAccessWriteMethodWithoutConnection()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $connector->write('test');
      $this->fail('Unable to occur error exception');
    } catch (\Exception $e) {
      $this->assertEquals(20, $e->getCode());
    }
  }

  public function testAccessCloseMethodWithoutConnection()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $connector->close();
      $this->fail('Unable to occur error exception');
    } catch (\Exception $e) {
      $this->assertEquals(20, $e->getCode());
    }
  }

  public function testAccessThenMethodWithoutConnection()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $connector->then(function ($conn) {
      });
      $this->fail('Unable to occur error exception');
    } catch (\Exception $e) {
      $this->assertEquals(20, $e->getCode());
    }
  }

  public function testAccessThenMethod()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $connector->connectTcp('google.com', 80, 100)->then(function ($conn) {
        $this->assertInstanceOf('\SimpleSocket\Connector', $conn);
      });
    } catch (\Exception $e) {
      $this->fail('Occur error exception');
    }
  }

  public function testAccessWriteMethod()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $instance = $connector->connectTcp('google.com', 80, 100)->write("GET / HTTP/1.1\r\n\Host: google.com\r\n\r\n");
      $this->assertInstanceOf('\SimpleSocket\Connector', $instance);
    } catch (\Exception $e) {
      $this->fail('Occur error exception');
    }
  }

  public function testAccessReadMethod()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $buf = $connector->connectTcp('google.com', 80, 100)->write("GET / HTTP/1.1\r\n\Host: google.com\r\n\r\n")->read(2048);
      $this->assertRegExp('/HTML/', (string) $buf);
    } catch (\Exception $e) {
      $this->fail('Occur error exception');
    }
  }

  public function testAccessCloseMethod()
  {
    try {
      $connector = new \SimpleSocket\Connector();
      $instance = $connector->connectTcp('google.com', 80, 100)->close();
      $this->assertInstanceOf('\SimpleSocket\Connector', $instance);
    } catch (\Exception $e) {
      $this->fail('Occur error exception');
    }
  }
}
