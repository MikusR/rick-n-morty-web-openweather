<?php

namespace App\Models;


class Episode
{
    private int $id;
    private string $name;
    private string $airDate;
    private string $episode;
    private ?CharacterCollection $characters;

    public function __construct(
        int $id,
        string $name,
        string $airDate,
        string $episode,
        CharacterCollection $characters = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->airDate = $airDate;
        $this->episode = $episode;
        $this->characters = $characters;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getAirDate(): string
    {
        return $this->airDate;
    }

    public function getEpisode(): string
    {
        return $this->episode;
    }

    public function getCharacters(): CharacterCollection
    {
        return $this->characters;
    }
}