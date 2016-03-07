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

  public function testIsEmailLink() {
    $this->assertTrue(is_email_link('mailto:zendzirou@gmail.com'));
    $this->assertFalse(is_email_link('http://ya.ru'));
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

  public function testIsNormalLink() {
    $this->assertTrue(is_normal_link('http://ya.ru/hello.txt'));
    $this->assertTrue(is_normal_link('https://ya.ru/hello.txt'));
    $this->assertTrue(is_normal_link('HTTP://ya.ru/hello.txt'));
    $this->assertFalse(is_normal_link('//ya.ru/hello.txt'));
    $this->assertFalse(is_normal_link('mailto:bubujka@ya.ru'));
  }

  public function testNiceLink() {
    $r = [
      'http://ya.ru'           => '<a href="http://ya.ru">ya.ru</a>',
      'http://ya.ru/link.txt'  => '<a href="http://ya.ru/link.txt">ya.ru</a>',
      'https://ya.ru/link.txt' => '<a href="https://ya.ru/link.txt">ya.ru</a>',
      'mailto:bubujka@ya.ru'   => '<a href="mailto:bubujka@ya.ru">bubujka@ya.ru</a>',
      'man gimp'               => 'man gimp',
    ];

    foreach ($r as $k => $v) {
      $this->assertEquals(nice_link($k), $v, 'Testing ' . $k);
    }
  }

  public function testOrderedExamples() {
    $t  = ordered_exampls('ordered_examples/1');
    $fn = function ($itm) {
      return data_directory() . '/ordered_examples/1/' . $itm;
    };
    $this->assertEquals($t, array_map($fn, [2, 3, 4, 5, 10, 100, 101]));
  }

  public function testOrderedExamplesHandleOnlyFiles() {
    $t  = ordered_exampls('ordered_examples/3');
    $fn = function ($itm) {
      return data_directory() . '/ordered_examples/3/' . $itm;
    };
    $this->assertEquals($t, array_map($fn, [1, 2, 4]));
  }

  public function testOrderedExamplesRaiseException() {
    $this->expectException(Exception::class);
    $t = ordered_exampls('ordered_examples/not_found');
  }

  public function testOrderedExamplesWithMeta() {
    $t  = ordered_exampls('ordered_examples/2');
    $fn = function ($itm) {
      return data_directory() . '/ordered_examples/2/' . $itm;
    };
    $this->assertEquals($t, array_map($fn, [2, 3, 1]));
  }
}
