<?php

declare(strict_types=1);

namespace App\Services\Apple;

use App\Contracts\DataProvider;
use App\DTOs\Release;
use App\DTOs\Track;
use App\DTOs\TrackList;
use Illuminate\Http\Client\Factory;
use Symfony\Component\DomCrawler\Crawler;

class Client implements DataProvider
{
    public function __construct(private readonly Factory $client)
    {
    }

    public function release(string $id): Release
    {
        $response = $this->client->get("https://music.apple.com/album/_/{$id}")->throw();

        $document = new Crawler($response->body());

        $tracks = new TrackList();

        foreach ($document->filter('div.content-container .songs-list div.songs-list-row[data-testid="track-list-item"]') as $trackInfo) {
            $track = new Crawler($trackInfo);

            $tracks->push(
                new Track(
                    number: (int) $track->filter('[data-testid="track-number"]')->text(),
                    title: $track->filter('.songs-list-row__song-name[data-testid="track-title"]')->text(),
                    artists: $track->filter('.songs-list-row__by-line')->text(''),
                    length: $track->filter('.songs-list__col--time time.songs-list-row__length')->text(),
                )
            );
        }

        return new Release(
            title: $document->filter('div.content-container h1.headings__title')->text(),
            trackList: $tracks,
        );
    }
}
