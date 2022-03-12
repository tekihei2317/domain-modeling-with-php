<?php

declare(strict_types=1);

namespace Tekihei2317\Core\UseCases;

use Tekihei2317\Core\Domain\Model\予約接種日;
use Tekihei2317\Core\Domain\Model\接種券番号;
use Tekihei2317\Core\Domain\Model\自治体番号;
use Tekihei2317\Core\Domain\Port\接種者Query;
use Tekihei2317\Core\Domain\Exception\PreconditionException;
use Tekihei2317\Core\Domain\Model\予約;

final class 予約登録UseCase
{
    public function __construct(
        private 接種者Query $query
    ) {
    }

    public function run(接種券番号 $接種券番号, 自治体番号 $自治体番号, 予約接種日 $予約接種日)
    {
        // 接種券番号と自治体番号から予約者を取得する
        $接種者 = $this->query->findBy接種券番号And自治体番号($接種券番号, $自治体番号);

        if ($接種者 === null) {
            throw new PreconditionException('該当する接種者が存在しません');
        }

        // 予約登録を行う
        $予約 = new 予約($予約接種日);
        $接種者->予約登録($予約);

        // 例外を拾って処理する?
    }
}
