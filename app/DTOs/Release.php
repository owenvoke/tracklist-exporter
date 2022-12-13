<?php

declare(strict_types=1);

namespace App\DTOs;

class Release
{
    public function __construct(
        public readonly string $title,
        public readonly TrackList $trackList,
    ) {
    }
}
