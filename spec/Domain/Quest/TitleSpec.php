<?php

declare(strict_types=1);

namespace spec\App\Domain\Quest;

use App\Domain\Quest\Title;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TitleSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith("Workout");
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Title::class);
    }

    function it_is_immutable(): void
    {
        $this->updateTitle("Homework")
            ->shouldBeAnInstanceOf(Title::class);

        $updatedTitle = $this->updateTitle("Homework");

        $updatedTitle->getTitle()
            ->shouldReturn("Homework");
    }
}
