<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Test\UseCase;

use PHPUnit\Framework\TestCase;
use Tekihei2317\Core\Domain\Exception\PreconditionException;
use Tekihei2317\Core\Domain\Model\予約;
use Tekihei2317\Core\Domain\Model\予約接種日;
use Tekihei2317\Core\Domain\Model\接種券番号;
use Tekihei2317\Core\Domain\Model\自治体番号;
use Tekihei2317\Core\Domain\Model\接種者;
use Tekihei2317\Core\Domain\Port\接種者Command;
use Tekihei2317\Core\Domain\Port\接種者Query;
use Tekihei2317\Core\Subdomain\Model\Date;
use Tekihei2317\Core\UseCases\予約登録UseCase;

class 予約登録Test extends TestCase
{
    protected function setUp(): void
    {
        $today = Date::createFromString('2022-01-01');
        $this->reservation = new 予約(予約接種日::createFromString('2022-01-08', $today));
    }

    /**
     * @test
     */
    public function run_()
    {
        $command = new class implements 接種者Command
        {
            public ?接種者 $接種者 = null;
            public function store(接種者 $接種者): void
            {
                $this->接種者 = $接種者;
            }
        };

        $useCase = new 予約登録UseCase(
            new class implements 接種者Query
            {
                public function findBy接種券番号And自治体番号(接種券番号 $接種券番号, 自治体番号 $自治体番号): ?接種者
                {
                    return new 接種者(1);
                }
            },
            $command
        );

        $reservationDate = 予約接種日::createFromString('2022-01-08', Date::createFromString('2022-01-01'));
        $useCase->run(
            new 接種券番号('0123456789'),
            new 自治体番号('012345'),
            $reservationDate,
        );

        $expected = new 接種者(
            1,
            new 予約($reservationDate)
        );

        $this->assertEquals($expected, $command->接種者);
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
            },
            new class implements 接種者Command
            {
                public function store(接種者 $接種者): void
                {
                    throw new \BadMethodCallException();
                }
            }
        );

        $useCase->run(
            new 接種券番号('0123456789'),
            new 自治体番号('012345'),
            予約接種日::createFromString('2022-01-08', Date::createFromString('2022-01-01'))
        );
    }
}
