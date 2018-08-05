<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\IncompleteQuestException;
use App\Domain\Exception\UnexpectedCallException;
use App\Domain\Quest\Difficulty;
use App\Domain\Quest\Experience;
use App\Domain\Quest\Reward;
use App\Domain\Quest\Title;
use App\Domain\Quest\Description;
use Ramsey\Uuid\Uuid;

class Quest
{
    private $uuid;

    private $title;

    private $description;

    private $rewards;

    private $difficulty;

    private $isComplete;

    private $experience;

    public function __construct(
        Title $title
    ) {
        $this->uuid = Uuid::uuid4();
        $this->title = $title;

        $this->description = new Description();
        $this->rewards = [];
        $this->difficulty = new Difficulty();
        $this->isComplete = false;
        $this->experience = new Experience();
    }

    public function updateDescription(Description $description): void
    {
        $this->description = $description;
    }

    public function updateDifficulty(Difficulty $difficulty): void
    {
        $this->difficulty = $difficulty;
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
        return $this->experience;
    }

    public function addReward(Reward $reward): void
    {
        array_push($this->rewards, $reward);
    }

    /**
     * @throws IncompleteQuestException
     */
    public function receiveRewards(): array
    {
        if (!$this->isComplete) {
            throw new IncompleteQuestException();
        }

        return $this->rewards;
    }

    /**
     * @throws IncompleteQuestException
     */
    public function receiveExperience(): Experience
    {
        if (!$this->isComplete) {
            throw new IncompleteQuestException();
        }

        $this->calcTheExperienceForTheQuest();

        return $this->experience;
    }

    public function rewards(): array
    {
        return $this->rewards;
    }

    public function isComplete(): bool
    {
        return $this->isComplete;
    }

    /**
     * @throws UnexpectedCallException
     */
    public function completeTheQuest(): void
    {
        if ($this->isComplete) {
            throw new UnexpectedCallException("The quest is already complete");
        }

        $this->isComplete = true;
    }

    private function calcTheExperienceForTheQuest(): void
    {
        switch ($this->difficulty->getDifficulty()) {
            case "easy":
                $this->experience = $this->experience->increaseExperience(20);
                break;
            case "medium":
                $this->experience = $this->experience->increaseExperience(50);
                break;
            case "hard":
                $this->experience = $this->experience->increaseExperience(150);
                break;
            case "very hard":
                $this->experience = $this->experience->increaseExperience(300);
                break;
            case "impossible":
                $this->experience = $this->experience->increaseExperience(500);
                break;
        }
    }
}