<?php

namespace App\Models;

class EpisodeCollection
{
    private array $episodes;

    public function __construct(array $episodes = [])
    {
        $this->episodes = $episodes;
    }

    public function add(Episode $episode): void
    {
        $this->episodes[$episode->getEpisode()] = $episode;
    }

    public function list(): array
    {
        return $this->episodes;
    }

}