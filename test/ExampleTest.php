<?php
class ExampleTest extends PHPUnit_Framework_TestCase {
  public static function setUpBeforeClass() {
    data_directory(__DIR__ . '/data');
  }

  public function testCanBeNegated() {
    //new Example('ololo');
    $this->assertEquals(-1, -1);
  }
}
