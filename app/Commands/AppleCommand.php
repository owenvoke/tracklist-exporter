<?php

declare(strict_types=1);

namespace App\Commands;

use App\DTOs\Track;
use App\Services\Apple\Client as AppleClient;
use LaravelZero\Framework\Commands\Command;

class AppleCommand extends Command
{
    /** {@inheritdoc} */
    protected $signature = 'apple { release-id : The id of the release on Apple Music }';

    /** {@inheritdoc} */
    protected $description = 'Export an Apple Music release as a track list';

    public function handle(AppleClient $client): void
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
