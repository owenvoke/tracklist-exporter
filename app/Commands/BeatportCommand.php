<?php

declare(strict_types=1);

namespace App\Commands;

use App\Commands\Concerns\InteractsWithReleases;
use App\Services\Beatport\Client as BeatportClient;
use LaravelZero\Framework\Commands\Command;

class BeatportCommand extends Command
{
    use InteractsWithReleases;

    /** {@inheritdoc} */
    protected $signature = 'beatport { release-id : The id of the release on Beatport }';

    /** {@inheritdoc} */
    protected $description = 'Export a Beatport release as a track list';

    public function handle(BeatportClient $client): void
    {
        $this->exportRelease($client, $this->argument('release-id'));
    }
}
