<?php

declare(strict_types=1);

namespace spec\App\Domain\Quest;

use App\Domain\Quest\Description;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DescriptionSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedThrough("fromString", ["Do a workout"]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Description::class);
    }

    function it_is_immutable(): void
    {
        $this->updateDescription("Do a homework")
            ->shouldBeAnInstanceOf(Description::class);

        $updatedTitle = $this->updateDescription("Do a homework");

        $updatedTitle->getDescription()
            ->shouldReturn("Do a homework");
    }
}
