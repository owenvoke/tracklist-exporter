<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\Release;

interface DataProvider
{
    public function release(string $id): Release;
}
