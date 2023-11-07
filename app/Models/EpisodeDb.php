<?php

namespace App\Models;

use App\Api;

class EpisodeDb
{
    private static EpisodeCollection $episodes;

    public static function init(): void
    {
        self::$episodes = (new api)->fetchEpisodes();
    }

    public static function getEpisodeId(string $episode): int
    {
        return self::$episodes->list()[$episode]->getId();
    }

    public static function list(): EpisodeCollection
    {
        return self::$episodes;
    }
}