<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Events\DescriptionWasUpdated;
use App\Domain\Events\DifficultyWasUpdated;
use App\Domain\Events\ExperienceWasReceived;
use App\Domain\Events\QuestWasCompleted;
use App\Domain\Events\QuestWasStarted;
use App\Domain\Events\RewardsWereReceived;
use App\Domain\Events\RewardWasAdded;
use App\Domain\Events\TitleWasUpdated;
use App\Domain\Exception\IncompleteQuestException;
use App\Domain\Exception\Quest\TryingToReceiveTwice;
use App\Domain\Exception\UnexpectedCallException;
use App\Domain\Quest\CompletedAt;
use App\Domain\Quest\Description;
use App\Domain\Quest\Difficulty;
use App\Domain\Quest\Experience;
use App\Domain\Quest\Reward;
use App\Domain\Quest\StartedAt;
use App\Domain\Quest\Title;
use Assert\Assertion;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;

class Quest extends AggregateRoot
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @var Title
     */
    private $title;

    /**
     * @var Description
     */
    private $description;

    /**
     * @var Reward[]
     */
    private $rewards;

    /**
     * @var Difficulty
     */
    private $difficulty;

    /**
     * @var bool
     */
    private $isComplete;

    /**
     * @var Experience
     */
    private $experience;

    /**
     * @var StartedAt
     */
    private $startedAt;

    /**
     * @var CompletedAt
     */
    private $completedAt;

    public static function startNewQuest(
        Title $title,
        Description $description,
        Difficulty $difficulty,
        array $rewards
    ): self {
        $uuid = Uuid::uuid4();

        $instance = new self();

        $instance->recordThat(QuestWasStarted::occur($uuid->toString(), [
            'title'  => $title,
            'description' => $description,
            'difficulty' => $difficulty,
            'rewards' => $rewards,
            'is_complete' => false,
            'started_at' => new StartedAt('now'),
        ]));

        return $instance;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function difficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function experienceForTheQuest(): Experience
    {
        $experience = $this->calcExperienceForTheQuest();

        return $experience;
    }

    public function startedAt(): StartedAt
    {
        return $this->startedAt;
    }

    public function rewards(): array
    {
        return $this->rewards;
    }

    public function isComplete(): bool
    {
        return $this->isComplete;
    }

    public function completedAt(): CompletedAt
    {
        if (!$this->isComplete()) {
            throw new UnexpectedCallException();
        }

        return $this->completedAt;
    }

    public function updateTitle(Title $updatedTitle): void
    {
        Assertion::notEmpty($updatedTitle->toString());

        if (!$updatedTitle->toString() !== $this->title) {
            $this->recordThat(TitleWasUpdated::occur(
                $this->uuid->toString(),
                [
                    'updated_title' => $updatedTitle,
                    'old_title' => $this->title
                ]
            ));
        }
    }

    public function updateDescription(Description $updatedDescription): void
    {
        if (!$updatedDescription->getDescription() !== $this->title) {
            $this->recordThat(DescriptionWasUpdated::occur(
                $this->uuid->toString(),
                [
                    'updated_description' => $updatedDescription,
                    'old_description' => $this->description
                ]
            ));
        }
    }

    public function updateDifficulty(Difficulty $updatedDifficulty): void
    {
        if (!$updatedDifficulty !== $this->difficulty) {
            $this->recordThat(DifficultyWasUpdated::occur(
                $this->uuid->toString(),
                [
                    'updated_difficulty' => $updatedDifficulty,
                    'old_difficulty' => $this->difficulty
                ]
            ));
        }
    }

    public function addReward(Reward $newReward): void
    {
        if (!array_key_exists($newReward->getReward(), $this->rewards())) {
            $this->recordThat(RewardWasAdded::occur(
                $this->uuid->toString(),
                [
                    'new_reward' => $newReward,
                ]
            ));
        }
    }

    /**
     * @throws IncompleteQuestException
     */
    public function receiveRewards(): void
    {
        if (!$this->isComplete()) {
            throw new IncompleteQuestException();
        }

        $this->recordThat(RewardsWereReceived::occur(
            $this->uuid->toString(),
            [
                'received_rewards' => $this->rewards(),
            ]
        ));
    }

    /**
     * @throws IncompleteQuestException
     */
    public function receiveExperience(): void
    {
        if (!$this->isComplete()) {
            throw new IncompleteQuestException();
        }

        foreach ($this->popRecordedEvents() as $event) {
            if (ExperienceWasReceived::class === $event->messageName()) {
                throw TryingToReceiveTwice::experience();
            }
        }

        $this->experience = $this->calcExperienceForTheQuest();

        $this->recordThat(ExperienceWasReceived::occur(
            $this->uuid->toString(),
            [
                'received_experience' => $this->experience
            ]
        ));
    }

    public function completeTheQuest(): void
    {
        if ($this->isComplete()) {
            throw new UnexpectedCallException("The quest is already complete");
        }

        if (true !== $this->isComplete) {
            $this->recordThat(QuestWasCompleted::occur(
                $this->uuid->toString(),
                [
                    'is_complete' => true,
                    'completed_at' => new CompletedAt('now'),
                    'old_state_is_complete' => $this->isComplete
                ]
            ));
        }
    }

    private function calcExperienceForTheQuest(): Experience
    {
        switch ($this->difficulty()->getDifficulty()) {
            case "easy":
                return Experience::fromInt(20);
                break;
            case "medium":
                return Experience::fromInt(50);
                break;
            case "hard":
                return Experience::fromInt(150);
                break;
            case "very hard":
                return Experience::fromInt(300);
                break;
            case "impossible":
                return Experience::fromInt(500);
                break;
        }
    }

    protected function aggregateId(): string
    {
        return $this->uuid->toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        switch (\get_class($event)) {
            case QuestWasStarted::class:
                /** @var QuestWasStarted $event */

                $this->whenQuestWasStarted($event);
                break;
            case TitleWasUpdated::class:
                /** @var TitleWasUpdated $event */

                $this->title = $event->updatedTitle();
                break;
            case DescriptionWasUpdated::class:
                /** @var DescriptionWasUpdated $event */

                $this->description = $event->updatedDescription();
                break;
            case DifficultyWasUpdated::class:
                /** @var DifficultyWasUpdated $event */

                $this->difficulty = $event->updatedDifficulty();
                break;
            case RewardWasAdded::class:
                /** @var RewardWasAdded $event */

                $this->rewards[$event->newReward()->getReward()] = $event->newReward();
                break;
            case QuestWasCompleted::class:
                /** @var QuestWasCompleted $event */

                $this->whenQuestWasCompleted($event);
                break;
            case RewardsWereReceived::class:
                /** @var RewardsWereReceived @event */

                $this->whenRewardsWereReceived();
                break;

            case ExperienceWasReceived::class:
                /** @var ExperienceWasReceived @event */

                $this->whenExperienceWasReceived();
                break;
        }
    }

    private function whenQuestWasStarted(QuestWasStarted $event): void
    {
        $this->uuid = Uuid::fromString($event->aggregateId());

        $this->title = $event->title();

        $this->description = $event->description();

        $this->isComplete = $event->isComplete();

        $this->difficulty = $event->difficulty();

        foreach ($event->rewards() as $reward) {
            $this->rewards[$reward->getReward()] = $reward;
        }

        $this->startedAt = $event->startedAt();

        $this->experience = $this->calcExperienceForTheQuest();
    }

    private function whenQuestWasCompleted(QuestWasCompleted $event): void
    {
        $this->isComplete = $event->isComplete();
        $this->completedAt = $event->completedAt();
    }

    private function whenRewardsWereReceived(): void
    {
        unset($this->rewards);

        $reward = Reward::fromString();
        $this->rewards[$reward->getReward()] = $reward;
    }

    private function whenExperienceWasReceived(): void
    {
        unset($this->experience);

        $experience = Experience::fromInt(0);
        $this->experience = $experience;
    }
}