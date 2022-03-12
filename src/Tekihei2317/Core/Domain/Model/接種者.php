<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Domain\Model;

use Tekihei2317\Core\Domain\Exception\InvalidOperationException;

final class 接種者
{
    public function __construct(
        private int $id,
        private 接種ステータス $接種ステータス = 接種ステータス::未予約,
        private ?予約 $予約 = null,
        private ?接種 $接種 = null,
    ) {
        if ($接種ステータス === 接種ステータス::未予約) {
            assert($予約 === null);
            assert($接種 === null);
        }
        if ($接種ステータス === 接種ステータス::予約完了) {
            assert($予約 !== null);
            assert($接種 === null);
        }
        if ($接種ステータス === 接種ステータス::接種完了) {
            assert($予約 !== null);
            assert($接種 !== null);
        }
    }

    public function 予約登録(予約 $予約): self
    {
        if ($this->接種ステータス !== 接種ステータス::未予約) {
            throw new InvalidOperationException('このステータスでは予約できません');
        }

        return new self(
            $this->id,
            接種ステータス::予約完了,
            $予約
        );
    }
}
