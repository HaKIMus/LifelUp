<?php

declare(strict_types=1);

namespace App\Domain\Quest;

class Description
{
    private $description;

    public function __construct(string $description = null)
    {
        $this->description = $description;
    }

    public function updateDescription(string $description): self
    {
        $updatedDescription = new self($description);

        return $updatedDescription;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
