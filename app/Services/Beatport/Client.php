<?php

declare(strict_types=1);

namespace App\Services\Beatport;

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
        $response = $this->client->get("https://www.beatport.com/release/_/{$id}")->throw();

        $document = new Crawler($response->body());

        $tracks = new TrackList();

        foreach ($document->filter('ul.bucket-items.ec-bucket li.bucket-item.track') as $trackInfo) {
            $track = new Crawler($trackInfo);

            $tracks->push(
                new Track(
                    number: (int) $track->filter('.buk-track-num')->text(),
                    title: $track->filter('.buk-track-meta-parent .buk-track-title .buk-track-primary-title')->text(),
                    artists: $track->filter('.buk-track-meta-parent .buk-track-artists')->text(''),
                    length: $track->filter('.buk-track-meta-parent .buk-track-length')->text(),
                )
            );
        }

        return new Release(
            title: $document->filter('.interior-release-chart-content h1')->text(),
            trackList: $tracks,
        );
    }
}
