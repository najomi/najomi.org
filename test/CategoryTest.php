<?php
class CategoryTest extends PHPUnit_Framework_TestCase {
  public static function setUpBeforeClass() {
    data_directory(__DIR__ . '/data/category');
  }

  public function testCategories() {
    $c    = new Category('php');
    $cats = $c->categories();
    $this->assertEquals(count($cats), 2);
    $this->assertEquals($cats[0]->name(), 'gd');
    $this->assertEquals($cats[1]->name(), 'unlink');
  }

  public function testCategoryHaveParent() {
    $c = new Category('php/unlink');
    $this->assertInstanceOf(Category::class, $c->parent);
    $this->assertEquals('php', $c->parent->name());
  }

  public function testConstructionWithPath() {
    $c = new Category('php');
    $this->assertInstanceOf(Category::class, $c);
  }

  public function testExceptionOnWrongDirectory() {
    $this->expectException(Exception::class);
    $c = new Category('not_found');
  }

  public function testName() {
    $c = new Category('php');
    $this->assertEquals($c->name(), 'php');
  }

  public function testNameInMetaYaml() {
    $c = new Category('name');
    $this->assertEquals($c->name(), 'ololo');
  }
}
