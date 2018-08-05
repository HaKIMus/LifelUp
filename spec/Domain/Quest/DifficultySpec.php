<?php

namespace spec\App\Domain\Quest;

use App\Domain\Quest\Difficulty;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DifficultySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Difficulty::class);
    }

    function it_has_medium_difficulty_by_default(): void
    {
        $this->getDifficulty()
            ->shouldReturn("medium");
    }

    function it_is_immutable(): void
    {
        $this->updateDifficulty(Difficulty::IMPOSSIBLE)
            ->shouldBeAnInstanceOf(Difficulty::class);

        $updatedTitle = $this->updateDifficulty(Difficulty::IMPOSSIBLE);

        $updatedTitle->getDifficulty()
            ->shouldReturn("impossible");
    }

    function it_has_five_levels_of_difficulty(): void
    {
        # Easy
        $easy = $this->updateDifficulty(Difficulty::EASY);

        $easy->getDifficulty()
            ->shouldReturn("easy");

        # Medium

        $medium = $this->updateDifficulty(Difficulty::MEDIUM);

        $medium->getDifficulty()
            ->shouldReturn("medium");

        # Hard
        $hard = $this->updateDifficulty(Difficulty::HARD);

        $hard->getDifficulty()
            ->shouldReturn("hard");

        # Very hard
        $veryHard = $this->updateDifficulty(Difficulty::VERY_HARD);

        $veryHard->getDifficulty()
            ->shouldReturn("very hard");

        # Impossible
        $impossible = $this->updateDifficulty(Difficulty::IMPOSSIBLE);

        $impossible->getDifficulty()
            ->shouldReturn("impossible");
    }
}
