<?php

namespace App\Controllers;

use App\Api;
use App\Models\EpisodeDb;
use App\Response;

class EpisodeController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        return new Response(
            'episode/index',
            [
                //'episodes' => $this->api->fetchEpisodes(),
                'episodes' => EpisodeDb::list(),
            ]
        );
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];
        return new Response(
            'episode/show',
            [
                'episode' => $this->api->fetchEpisode($id),
            ]
        );
    }

    public function search(array $vars): Response
    {
        $episode = strtoupper(($vars['episode']) ?? $_GET['episode']);
        return new Response(
            'episode/show',
            [
                'episode' => $this->api->fetchEpisode(EpisodeDb::getEpisodeId($episode)),
            ]
        );
    }
}