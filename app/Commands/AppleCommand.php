<?php

declare(strict_types=1);

namespace App\Commands;

use App\Commands\Concerns\InteractsWithReleases;
use App\Services\Apple\Client as AppleClient;
use LaravelZero\Framework\Commands\Command;

class AppleCommand extends Command
{
    use InteractsWithReleases;

    /** {@inheritdoc} */
    protected $signature = 'apple { release-id : The id of the release on Apple Music }';

    /** {@inheritdoc} */
    protected $description = 'Export an Apple Music release as a track list';

    public function handle(AppleClient $client): void
    {
        $this->exportRelease($client, $this->argument('release-id'));
    }
}
