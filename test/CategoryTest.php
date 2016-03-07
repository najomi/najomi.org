<?php
class CategoryTest extends PHPUnit_Framework_TestCase {
  public static function setUpBeforeClass() {
    data_directory(__DIR__ . '/data/category');
  }

  public function testConstructionWithPath() {
    $c = new Category('php');
    $this->assertInstanceOf(Category::class, $c);
  }

  public function testExceptionOnWrongDirectory() {
    $this->expectException(Exception::class);
    $c = new Category('not_found');
  }
}
