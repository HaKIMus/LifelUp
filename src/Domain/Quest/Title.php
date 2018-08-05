<?php

declare(strict_types=1);

namespace App\Domain\Quest;

class Title
{
    private $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function updateTitle(string $title): self
    {
        $updatedTitle = new self($title);

        return $updatedTitle;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
