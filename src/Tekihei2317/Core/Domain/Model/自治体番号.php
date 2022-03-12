<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Domain\Model;

use Tekihei2317\Core\Domain\Exception\InvalidException;

final class 自治体番号
{
    public function __construct(private string $code)
    {
        if (!preg_match('/\A[0-9]{6}\z/', $code)) {
            throw new InvalidException('Invalid code:' . $code);
        }
    }

    public function toString(): string
    {
        return $this->code;
    }
}
