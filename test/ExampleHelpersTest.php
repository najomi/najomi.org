<?php
class ExampleHelpersTest extends PHPUnit_Framework_TestCase {
  private $invalid_categories = [
    '', 'with!bang', 'space/i n side/',
    'with"\'quotes', 'рашнлеттерс'];

  private $valid_categories = [
    '_nix/imagemagic', 'php', 'CapitalLetters',
    'php/php7', 'very/very/long',
    'ubuntu/14.04', '_-_/_-_', '2008'];

  public static function setUpBeforeClass() {
    data_directory(__DIR__ . '/data');
  }

  public function testDataHelper() {
    $this->assertEquals(data('lol'), data_directory() . '/lol');
  }

  public function testIsCategoryExists() {
    $this->assertTrue(is_category_exists('is_category_exists/1'));
    $this->assertFalse(is_category_exists('is_category_exists/500'));
    $this->assertFalse(is_category_exists('is_category_exists/2'));
  }

  public function testIsCategoryExistsRaiseException() {
    $this->expectException(Exception::class);
    is_category_exists('php/рашндир');
  }

  public function testIsCategoryPath() {
    foreach ($this->valid_categories as $v) {
      $this->assertTrue(is_category_path($v), 'Testing: ' . $v);
    }

    foreach ($this->invalid_categories as $v) {
      $this->assertFalse(is_category_path($v), 'Testing: ' . $v);
    }
  }

  public function testIsExampleExists() {
    $this->assertTrue(is_example_exists('is_example_exists/1'));
    $this->assertFalse(is_example_exists('is_example_exists/500'));
    $this->assertFalse(is_example_exists('is_example_exists/2'));
  }

  public function testIsExampleExistsRaiseException() {
    $this->expectException(Exception::class);
    is_example_exists('php/HelLo.md');
  }

  public function testIsExamplePathHandleCategory() {
    foreach ($this->valid_categories as $v) {
      $this->assertTrue(is_example_path($v . '/100500'), 'Testing: ' . $v);
    }

    foreach ($this->invalid_categories as $v) {
      $this->assertFalse(is_example_path($v . '/100500'), 'Testing: ' . $v);
    }
  }

  public function testIsExamplePathSpecialCases() {
    $valid   = ['php/100', 'php/hello.md', 'php/hello.html', 'php/h.1l3lo_w.rl2d-.md'];
    $invalid = ['100500', 'php/0', 'php/-1', 'php/0.2', 'php/HeLlo.md', 'php/hello.txt', 'php/привет.md'];

    foreach ($valid as $v) {
      $this->assertTrue(is_example_path($v), 'Testing: ' . $v);
    }

    foreach ($invalid as $v) {
      $this->assertFalse(is_example_path($v), 'Testing: ' . $v);
    }
  }
}
