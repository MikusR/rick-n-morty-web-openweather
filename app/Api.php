<?php

namespace App;

use App\Models\Character;
use App\Models\CharacterCollection;
use App\Models\Episode;
use App\Models\EpisodeCollection;
use GuzzleHttp\Client;

class Api
{
    private Client $client;
    private const EPISODE_URL = 'https://rickandmortyapi.com/api/episode';
    private const CHARACTER_URL = 'https://rickandmortyapi.com/api/character';


    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchEpisodes(): EpisodeCollection
    {
        $episodes = new EpisodeCollection();

        $page = 1;

        while (true) {
            $response = $this->client->get(self::EPISODE_URL . "?page=$page");

            $data = json_decode((string)$response->getBody());

            foreach ($data->results as $result) {
                $episodes->add(
                    new Episode(
                        $result->id,
                        $result->name,
                        $result->air_date,
                        $result->episode
                    )
                );
            }

            $page++;

            if ($data->info->next == null) {
                break;
            }
        }

        return $episodes;
    }

    public function fetchEpisode(int $id): Episode
    {
        $response = $this->client->get(self::EPISODE_URL . "/$id");

        $data = json_decode((string)$response->getBody());
        $characters = new CharacterCollection();
        foreach ($data->characters as $character) {
            $characters->add($this->fetchCharacter($character));
        }
        return new Episode(
            $data->id,
            $data->name,
            $data->air_date,
            $data->episode,
            $characters
        );
    }

    public function fetchCharacter(string $url): Character
    {
        $response = $this->client->get("$url");

        $character = json_decode((string)$response->getBody());

        return new Character(
            $character->id,
            $character->name,
            $character->status,
            $character->species,
            $character->type,
            $character->gender,
            $character->image
        );
    }
}