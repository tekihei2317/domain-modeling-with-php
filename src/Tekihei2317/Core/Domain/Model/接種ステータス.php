<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Domain\Model;

enum 接種ステータス
{
    case 未予約;
    case 予約完了;
    case 接種完了;
}
