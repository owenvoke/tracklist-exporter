<?php

declare(strict_types=1);

namespace App\Commands;

use App\DTOs\Track;
use App\Services\Beatport\Client as BeatportClient;
use LaravelZero\Framework\Commands\Command;

class BeatportCommand extends Command
{
    /** {@inheritdoc} */
    protected $signature = 'beatport { release-id : The id of the release on Beatport }';

    /** {@inheritdoc} */
    protected $description = 'Export a Beatport release as a track list';

    public function handle(BeatportClient $client): void
    {
        $client->release($this->argument('release-id'))
            ->trackList
            ->each(fn (Track $track) => $this->line(
                sprintf(
                    "%s. %s%s (%s)",
                    $track->number,
                    $track->title,
                    $track->artists !== '' ? " - {$track->artists}" : null,
                    $track->length,
                )
            ));
    }
}
