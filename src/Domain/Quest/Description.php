<?php

declare(strict_types=1);

namespace App\Domain\Quest;

use Assert\Assertion;

class Description
{
    private $description;

    public static function fromString(string $description): self
    {
        return new self($description);
    }

    private function __construct(string $description = null)
    {
        Assertion::notEmpty($description);

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
