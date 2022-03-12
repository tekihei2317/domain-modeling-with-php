<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Domain\Model;

final class 予約
{
    public function __construct(private 予約接種日 $予約摂取日)
    {
    }
}
