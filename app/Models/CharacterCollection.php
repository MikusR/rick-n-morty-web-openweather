<?php

namespace App\Models;

class CharacterCollection
{
    private array $characters;

    public function __construct(array $characters = [])
    {
        $this->characters = $characters;
    }

    public function add(Character $character): void
    {
        $this->characters[$character->getId()] = $character;
    }

    public function list(): array
    {
        return $this->characters;
    }
}