<?php

declare(strict_types=1);

namespace App\Domain\Quest;

use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Exception\Quest\NegativeExperienceException;

class Experience
{
    private $exp;

    public static function fromInt(int $exp): self
    {
        return new self($exp);
    }

    /**
     * @throws NegativeExperienceException
     */
    private function __construct(int $exp)
    {
        if ($exp < 0) {
            throw new NegativeExperienceException();
        }

        $this->exp = $exp;
    }

    /**
     * @throws NegativeExperienceException
     */
    public function increaseExperience(int $exp): self
    {
        if ($exp < 0) {
            throw new NegativeExperienceException();
        }

        $updatedExperience = new self($this->exp += $exp);

        return $updatedExperience;
    }

    public function getExperience(): int
    {
        return $this->exp;
    }
}
