<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Domain\Port;

use Tekihei2317\Core\Domain\Model\接種者;

interface 接種者Command
{
    public function store(接種者 $接種者): void;
}
