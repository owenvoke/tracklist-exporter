<?php

declare(strict_types=1);

namespace App\DTOs;

class Track
{
    public function __construct(
        public readonly int $number,
        public readonly string $title,
        public readonly string $artists,
        public readonly string $length,
    ) {
    }
}
