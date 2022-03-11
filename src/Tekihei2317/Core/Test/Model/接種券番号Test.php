<?php

namespace Tekihei2317\Core\Test\Model;

use PHPUnit\Framework\TestCase;
use Tekihei2317\Core\Domain\Exception\InvalidException;
use Tekihei2317\Core\Domain\Model\接種券番号;

class 接種券番号Test extends TestCase
{
    /**
     * @test
     */
    public function construct_()
    {
        $actual = new 接種券番号('0123456789');

        $this->assertEquals('0123456789', $actual->toString());
    }

    /**
     * @test
     */
    public function construct_数字以外の場合はエラーになること()
    {
        $this->expectException(InvalidException::class);

        new 接種券番号('A123456789');
    }
}
