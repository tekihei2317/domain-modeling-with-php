<?php

declare(strict_types=1);

namespace Tekihei2317\Core\Domain\Model;

use Tekihei2317\Core\Domain\Exception\InvalidException;
use Tekihei2317\Core\Domain\Exception\PreconditionException;
use Tekihei2317\Core\Subdomain\Model\Date;

final class 予約接種日
{
    private function __construct(private Date $date)
    {
    }

    public static function createFromString(string $dateString, Date $today)
    {
        $date = Date::createFromString($dateString);

        if ($date->lessThan($today->addDay(7)) || $date->greaterThan($today->addDay(30))) {
            throw new PreconditionException;
        }

        return new self($date);
    }

    public function toString(): string
    {
        return $this->date->toDateString();
    }
}
