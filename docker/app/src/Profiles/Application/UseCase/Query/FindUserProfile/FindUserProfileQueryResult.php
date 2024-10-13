<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\FindUserProfile;

use App\Profiles\Application\DTO\Profile\ProfileDTO;

readonly class FindUserProfileQueryResult
{
    public function __construct(public ?ProfileDTO $profileDTO)
    {
    }
}
