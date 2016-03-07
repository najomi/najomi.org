<?php
class ExampleTest extends PHPUnit_Framework_TestCase {
  public static function setUpBeforeClass() {
    data_directory(__DIR__ . '/data');
  }

  public function testExceptionOnNotExistedPath() {
    $this->expectException(Exception::class);
    new Example('example/2');
  }

  public function testExceptionOnWrongPath() {
    $this->expectException(Exception::class);
    new Example('example/WRONG.md');
  }
}
