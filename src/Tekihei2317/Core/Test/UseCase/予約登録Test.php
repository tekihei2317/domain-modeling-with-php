<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Test\UseCase;

use PHPUnit\Framework\TestCase;
use Tekihei2317\Core\Domain\Exception\InvalidOperationException;
use Tekihei2317\Core\Domain\Exception\PreconditionException;
use Tekihei2317\Core\Domain\Model\予約;
use Tekihei2317\Core\Domain\Model\予約接種日;
use Tekihei2317\Core\Domain\Model\接種券番号;
use Tekihei2317\Core\Domain\Model\自治体番号;
use Tekihei2317\Core\Domain\Model\接種者;
use Tekihei2317\Core\Domain\Port\接種者Query;
use Tekihei2317\Core\Subdomain\Model\Date;
use Tekihei2317\Core\UseCases\予約登録UseCase;

class 予約登録Test extends TestCase
{
    // TODO: 正常系
    private 予約 $reservation;

    protected function setUp(): void
    {
        $today = Date::createFromString('2022-01-01');
        $this->reservation = new 予約(予約接種日::createFromString('2022-01-08', $today));
    }

    /**
     * @test
     */
    public function run_接種者が存在しない場合はエラーになること()
    {
        $this->expectException(PreconditionException::class);

        $useCase = new 予約登録UseCase(
            new class implements 接種者Query
            {
                public function findBy接種券番号And自治体番号(接種券番号 $接種券番号, 自治体番号 $自治体番号): ?接種者
                {
                    return null;
                }
            }
        );

        $useCase->run(
            new 接種券番号('0123456789'),
            new 自治体番号('012345'),
            予約接種日::createFromString('2022-01-08', Date::createFromString('2022-01-01'))
        );
    }

    /**
     * @test
     */
    public function run_予約済みの場合はエラーになること()
    {
        $this->expectException(InvalidOperationException::class);

        $useCase = new 予約登録UseCase(
            new class implements 接種者Query
            {
                public function findBy接種券番号And自治体番号(接種券番号 $接種券番号, 自治体番号 $自治体番号): ?接種者
                {
                    $today = Date::createFromString('2022-01-01');
                    return new 接種者(
                        id: 1,
                        予約: new 予約(予約接種日::createFromString('2022-01-08', $today))
                    );
                }
            }
        );

        $useCase->run(
            new 接種券番号('0123456789'),
            new 自治体番号('012345'),
            予約接種日::createFromString('2022-01-08', Date::createFromString('2022-01-01'))
        );
    }
    // 接種済みの場合
    // 指定した日付が範囲外の場合
}
