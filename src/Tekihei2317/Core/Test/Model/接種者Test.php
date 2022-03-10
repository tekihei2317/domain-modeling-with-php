<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Test\Model;

use PHPUnit\Framework\TestCase;
use Tekihei2317\Core\Domain\Model\予約;
use Tekihei2317\Core\Domain\Model\接種者;

final class 接種者Test extends TestCase
{
    /**
     * @test
     */
    public function 予約登録()
    {
        $recipient = new 接種者(1);
        $reservation = new 予約();

        $actual = $recipient->予約登録($reservation);
        $expected = new 接種者(1, $reservation, null);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function 予約登録エラー_予約完了時に予約登録を実行()
    {
        $this->expectException(Exception::class);

        $reservation = new 予約();
        $recipient = new 接種者(1, 予約: $reservation, 接種: null);

        // $recipient->予約登録($reservation);
    }
}
