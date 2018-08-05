<?php

namespace spec\App\Domain\Quest;

use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Exception\Quest\NegativeExperienceException;
use App\Domain\Quest\Experience;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExperienceSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Experience::class);
    }

    function it_is_0_by_default(): void
    {
        $this->getExperience()
            ->shouldReturn(0);
    }
    function it_is_immutable(): void
    {
        $this->increaseExperience(30)
            ->shouldBeAnInstanceOf(Experience::class);

        $updatedTitle = $this->increaseExperience(30);

        $updatedTitle->getExperience()
            ->shouldReturn(60);
    }

    function it_cant_be_increased_by_negative_number(): void
    {
        $this->shouldThrow(InvalidArgumentException::class)
            ->during("increaseExperience", [-30]);
    }

    function it_cant_be_negative(): void
    {
        $this->shouldThrow(NegativeExperienceException::class)
            ->during("__construct", [-20]);
    }
}
