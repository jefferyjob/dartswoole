<?php declare(strict_types=1);
namespace Dartswoole\Test;
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase {

    public function testName(){
        $this->assertTrue(true);
    }

    public function additionProvider(): array
    {
        return [
            [0, 0, 0],
            [0, 1, 1],
            [1, 0, 1],
            [1, 1, 2]
        ];
    }

    /**
     * @dataProvider additionProvider
     */
    public function testAdd(int $a, int $b, int $expected): void
    {
        $this->assertSame($expected, $a + $b, json_encode(array(
            'a' => $a,
            'b' => $b,
            'exp' => $expected
        )));
    }
}