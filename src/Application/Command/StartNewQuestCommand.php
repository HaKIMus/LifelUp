<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Quest\Description;
use App\Domain\Quest\Difficulty;
use App\Domain\Quest\Reward;
use App\Domain\Quest\Title;
use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class StartNewQuestCommand extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function withData(
        string $title,
        string $description,
        string $difficulty,
        array $rewards
    ): self {
        return new self([
            'title' => $title,
            'description' => $description,
            'difficulty' => $difficulty,
            'rewards' => $rewards
        ]);
    }

    public function getTitle(): Title
    {
        return Title::fromString($this->payload['title']);
    }

    public function getDescription(): Description
    {
        return Description::fromString($this->payload['description']);
    }

    public function getDifficulty(): Difficulty
    {
        return Difficulty::fromInt($this->payload['difficulty']);
    }

    /**
     * @return Reward[]
     */
    public function getRewards(): array
    {
        return array_map(function ($reward) {
            return Reward::fromString($reward);
        }, $this->payload['rewards']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'title');
        Assertion::keyExists($payload, 'description');
        Assertion::keyExists($payload, 'difficulty');

        $this->payload = $payload;
    }
}