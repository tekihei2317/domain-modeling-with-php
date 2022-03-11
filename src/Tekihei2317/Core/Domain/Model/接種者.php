<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Domain\Model;

use Tekihei2317\Core\Domain\Exception\InvalidOperationException;

final class 接種者
{
    public function __construct(
        private int $id,
        private ?予約 $予約 = null,
        private ?接種 $接種 = null,
    ) {
    }

    public function 予約登録(予約 $予約): self
    {
        if ($this->予約 !== null) {
            throw new InvalidOperationException('すでに予約しています');
        }

        return new self(
            $this->id,
            $予約
        );
    }
}
