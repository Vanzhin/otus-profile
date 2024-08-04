<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\FindProfile;

use App\Profiles\Application\DTO\Profile\ProfileDTO;

readonly class FindProfileQueryResult
{
    public function __construct(public ?ProfileDTO $profileDTO)
    {
    }
}
