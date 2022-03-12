<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Test\Model;

use PHPUnit\Framework\TestCase;
use Tekihei2317\Core\Domain\Model\予約;
use Tekihei2317\Core\Domain\Model\接種;
use Tekihei2317\Core\Domain\Model\接種者;
use Tekihei2317\Core\Domain\Model\予約接種日;
use Tekihei2317\Core\Domain\Model\接種ステータス;
use Tekihei2317\Core\Subdomain\Model\Date;
use Tekihei2317\Core\Domain\Exception\InvalidOperationException;

final class 接種者Test extends TestCase
{
    private Date $today;
    private 予約 $reservation;

    protected function setUp(): void
    {
        $this->today = Date::createFromString('2022-01-01');
        $this->reservation = new 予約(予約接種日::createFromString('2022-01-08', $this->today));
    }

    /**
     * @test
     */
    public function 予約登録()
    {
        $recipient = new 接種者(1);

        $actual = $recipient->予約登録($this->reservation);
        $expected = new 接種者(1, 接種ステータス: 接種ステータス::予約完了, 予約: $this->reservation, 接種: null);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function 予約登録エラー_予約完了時に予約登録を実行()
    {
        $this->expectException(InvalidOperationException::class);

        $recipient = new 接種者(
            1,
            接種ステータス: 接種ステータス::予約完了,
            予約: $this->reservation,
            接種: null
        );

        $recipient->予約登録($this->reservation);
    }

    /**
     * @test
     */
    public function 予約登録エラー_接種完了時に予約登録を実行()
    {
        $this->expectException(InvalidOperationException::class);

        $recipient = new 接種者(
            1,
            接種ステータス: 接種ステータス::接種完了,
            予約: $this->reservation,
            接種: new 接種
        );

        $recipient->予約登録($this->reservation);
    }
}
