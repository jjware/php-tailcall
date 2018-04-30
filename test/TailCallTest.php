<?php
declare(strict_types=1);

use JJWare\Utils\TailCall\TailCall;
use JJWare\Utils\TailCall\Ret;
use JJWare\Utils\TailCall\Sus;

use PHPUnit\Framework\TestCase;

class TailCallTest extends TestCase
{
    public static function drop(array $a, int $n): TailCall
    {
        return $n <= 0
            ? TailCall::ret($a)
            : TailCall::sus(function () use ($a, $n) {
                return self::drop(array_slice($a, 1), $n - 1);
            });
    }

    public function testRecursion()
    {
        $a = ['a', 'b', 'c', 'd'];
        $t = self::drop($a, 2);
        $this->assertEquals(['c', 'd'], $t->eval());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testRetResume()
    {
        TailCall::ret(1)->resume();
    }

    public function testSusResume()
    {
        $val = TailCall::sus(function () {
            return TailCall::ret(1);
        })->resume();
        $this->assertEquals(TailCall::ret(1), $val);
    }

    public function testRetEval()
    {
        $t = TailCall::ret(1);
        $this->assertEquals(1, $t->eval());
    }

    public function testSusEval()
    {
        $t = TailCall::sus(function () {
            return TailCall::ret(1);
        });
        $this->assertEquals(1, $t->eval());
    }

    public function testRetIsSuspended()
    {
        $t = TailCall::ret(1);
        $this->assertFalse($t->isSuspended());
    }

    public function testSusIsSuspended()
    {
        $t = TailCall::sus(function () {
            return TailCall::ret(1);
        });
        $this->assertTrue($t->isSuspended());
    }
}