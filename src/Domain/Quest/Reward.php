<?php

declare(strict_types=1);

namespace App\Domain\Quest;

class Reward
{
    private $reward;

    public function __construct(string $reward = null)
    {
        $this->reward = $reward;
    }

    public function updateReward(string $reward): self
    {
        $reward = new self($reward);

        return $reward;
    }

    public function toArray(): array
    {
        return [
            'reward' => $this->reward
        ];
    }

    public function getReward(): ?string
    {
        return $this->reward ?? 'none';
    }
}
