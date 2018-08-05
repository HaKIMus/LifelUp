<?php

namespace spec\App\Domain\Quest;

use App\Domain\Quest\Reward;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RewardSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(
            "A cookie"
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Reward::class);
    }

    function it_is_immutable(): void
    {
        $this->updateReward("Watching a movie")
            ->shouldBeAnInstanceOf(Reward::class);

        $updatedTitle = $this->updateReward("Watching a movie");

        $updatedTitle->getReward()
            ->shouldReturn("Watching a movie");
    }
}
