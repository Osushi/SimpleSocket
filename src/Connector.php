<?php

namespace SimpleSocket;

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
  throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
});

class Connector
{
  private $_socket = null;

  public function connectTcp(string $address, int $port, int $timeout = 30)
  {
    try {
      $this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage(), 10);
    }

    if ($timeout !== 30) {
      try {
        socket_set_option($this->_socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => $timeout, 'usec' => 0]);
        socket_set_option($this->_socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => $timeout, 'usec' => 0]);
      } catch (\Exception $e) {
        throw new \Exception($e->getMessage(), 10);
      }
    }

    try {
      socket_connect($this->_socket, $address, $port);
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage(), 10);
    }

    return $this;
  }

  public function read(int $length = 2048)
  {
    if ($this->_socket === null) {
      throw new \Exception('Didn\'t define socket connection', 20);
    }

    return socket_read($this->_socket, $length);
  }

  public function write(string $buf)
  {
    if ($this->_socket === null) {
      throw new \Exception('Didn\'t define socket connection', 20);
    }

    socket_write($this->_socket, $buf, strlen($buf));

    return $this;
  }

  public function close()
  {
    if ($this->_socket === null) {
      throw new \Exception('Didn\'t define socket connection', 20);
    }

    socket_close($this->_socket);
    $this->_socket = null;

    return $this;
  }

  public function then(callable $func)
  {
    if ($this->_socket === null) {
      throw new \Exception('Didn\'t define socket connection', 20);
    }

    $func($this);

    return $this;
  }
}
