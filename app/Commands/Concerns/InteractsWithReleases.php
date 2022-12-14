<?php

declare(strict_types=1);

namespace App\Commands\Concerns;

use App\Contracts\DataProvider;
use App\DTOs\Track;
use LaravelZero\Framework\Commands\Command;

/** @mixin Command */
trait InteractsWithReleases
{
    protected function exportRelease(DataProvider $client, string $release): void
    {
        $client->release($release)
            ->trackList
            ->each(fn (Track $track) => $this->line(
                sprintf(
                    '%s. %s%s (%s)',
                    $track->number,
                    $track->title,
                    $track->artists !== '' ? " - {$track->artists}" : null,
                    $track->length,
                )
            ));
    }
}
