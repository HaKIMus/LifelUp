<?php

declare(strict_types=1);

namespace App\Domain\Quest;

use App\Domain\Exception\InvalidArgumentException;
use Assert\Assertion;

class Difficulty
{
    const EASY = 1;
    const MEDIUM = 2;
    const HARD = 3;
    const VERY_HARD = 4;
    const IMPOSSIBLE = 5;

    private $difficulty;

    public static function fromInt(int $difficulty): self
    {
        return new self($difficulty);
    }

    private function __construct(int $difficulty)
    {
/*        if ($difficulty !== Difficulty::EASY
            && $difficulty !== Difficulty::MEDIUM
            && $difficulty !== Difficulty::HARD
            && $difficulty !== Difficulty::VERY_HARD
            && $difficulty !== Difficulty::IMPOSSIBLE
        ) {
            throw new InvalidArgumentException();
        }*/

        $this->difficulty = $difficulty;
    }

    public function updateDifficulty(int $difficulty): self
    {
        $difficulty = new self($difficulty);

        return $difficulty;
    }

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
    }
}
