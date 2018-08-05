<?php

namespace App\Domain\Quest;

use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Exception\Quest\NegativeExperienceException;

class Experience
{
    private $exp;

    /**
     * @throws NegativeExperienceException
     */
    public function __construct(int $exp = 0)
    {
        if ($exp < 0) {
            throw new NegativeExperienceException();
        }

        $this->exp = $exp;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function increaseExperience(int $exp): self
    {
        if ($exp < 0) {
            throw new InvalidArgumentException();
        }

        $updatedExperience = new self($this->exp += $exp);

        return $updatedExperience;
    }

    public function getExperience(): int
    {
        return $this->exp;
    }
}
