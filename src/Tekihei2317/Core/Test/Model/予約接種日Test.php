<?php

namespace Tekihei2317\Core\Test\Model;

use PHPUnit\Framework\TestCase;
use Tekihei2317\Core\Domain\Exception\PreconditionException;
use Tekihei2317\Core\Domain\Model\予約接種日;
use Tekihei2317\Core\Subdomain\Model\Date;

class 予約接種日Test extends TestCase
{
    /**
     * @test
     */
    public function createFromString_()
    {
        $actual = 予約接種日::createFromString('2022-01-08', Date::createFromString('2022-01-01'));

        $this->assertEquals('2022-01-08', $actual->toString());
    }

    /**
     * @test
     */
    public function createfromstring_6日後ならエラー()
    {
        $this->expectException(Preconditionexception::class);

        予約接種日::createFromString('2022-01-07', date::createFromString('2022-01-01'));
    }

    /**
     * @test
     */
    public function createfromstring_31日後ならエラー()
    {
        $this->expectException(PreconditionException::class);

        予約接種日::createFromString('2022-02-01', date::createFromString('2022-01-01'));
    }
}
