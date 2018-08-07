<?php

declare(strict_types=1);

namespace App\Domain\Quest;

use Assert\Assertion;

class Title
{
    private $title;

    private function __construct(string $title)
    {
        $this->title = $title;
    }

    public static function fromString(string $title): self
    {
        Assertion::notEmpty($title);

        return new self($title);
    }

    public function updateTitle(string $title): self
    {
        $updatedTitle = new self($title);

        return $updatedTitle;
    }

    public function toString(): string
    {
        return $this->title;
    }
}
