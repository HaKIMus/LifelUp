<?php

namespace App\Domain\Quest;

use App\Domain\Exception\InvalidArgumentException;

class Difficulty
{
    const EASY = 1;
    const MEDIUM = 2;
    const HARD = 3;
    const VERY_HARD = 4;
    const IMPOSSIBLE = 5;

    private $difficulty;

    public function __construct(int $difficulty = 2)
    {
        $this->difficulty = $difficulty;
    }

    public function updateDifficulty(int $difficulty): self
    {
        $difficulty = new self($difficulty);

        return $difficulty;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getDifficulty(): string
    {
        switch ($this->difficulty) {
            case Difficulty::EASY:
                return "easy";
                break;
            case Difficulty::MEDIUM:
                return "medium";
                break;
            case Difficulty::HARD:
                return "hard";
                break;
            case Difficulty::VERY_HARD:
                return "very hard";
                break;
            case Difficulty::IMPOSSIBLE:
                return "impossible";
                break;
        }

        throw new InvalidArgumentException();
    }
}
