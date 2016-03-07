<?php
class ExampleTest extends PHPUnit_Framework_TestCase {
  public static function setUpBeforeClass() {
    data_directory(__DIR__ . '/data');
  }

  public function testCategory() {
    $e = new Example('example/5');
    $this->assertInstanceOf(Category::class, $e->category);
  }

  public function testCategorySyntax() {
    $e = new Example('example/6');
    $this->assertEquals('ruby', $e->ft());
  }

  public function testCategorySyntaxDefault() {
    $e = new Example('example2/5');
    $this->assertEquals('txt', $e->ft());
  }

  public function testCategorySyntaxNestedInDirs() {
    $e = new Example('example/long/long/ago/6');
    $this->assertEquals('ruby', $e->ft());
  }

  public function testExceptionOnNotExistedPath() {
    $this->expectException(Exception::class);
    new Example('example/699');
  }

  public function testExceptionOnWrongPath() {
    $this->expectException(Exception::class);
    new Example('example/WRONG.md');
  }

  public function testKeywordsMethod() {
    $e = new Example('example/5');
    $this->assertEquals(['example примеры', 'example usage', 'example example'], $e->keywords());
  }

  public function testPropMethod() {
    $e = new Example('example/5');
    $this->assertEquals($e->prop('code'), 'ls');
    $this->assertNull($e->prop('notcode'));
  }

  public function testPropsMethod() {
    $e      = new Example('example/5');
    $keys   = array_keys($e->props());
    $values = array_values($e->props());
    sort($keys);
    sort($values);
    $this->assertEquals($keys, ['code', 'desc', 'ft', 'link', 'out']);
    $this->assertEquals($values, ['1.txt 2.txt', 'Hello', 'http://najomi.org', 'lisp', 'ls']);
  }

  public function testSimpleExample() {
    $e = new Example('example/5');
    $this->assertEquals($e->desc(), 'Hello');
    $this->assertEquals($e->code(), 'ls');
    $this->assertEquals($e->file_id(), '5');
    $this->assertEquals($e->id(), 3);
    $this->assertEquals($e->ft(), 'lisp');
    $this->assertEquals($e->url(), '/example/5');

  }
}
