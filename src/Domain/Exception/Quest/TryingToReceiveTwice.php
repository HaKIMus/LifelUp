<?php

declare(strict_types=1);

namespace App\Domain\Exception\Quest;

use App\Domain\Exception\Exception;

class TryingToReceiveTwice extends Exception
{
    public static function rewards(): self
    {
        return new self("The rewards were already received");
    }

    public static function experience(): self
    {
        return new self("The experience was already received");
    }
}