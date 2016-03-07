<?php
class ExampleTest extends PHPUnit_Framework_TestCase {
  public function testCanBeNegated() {
    new Example('ololo');
    $this->assertEquals(-1, 2);
  }
}
