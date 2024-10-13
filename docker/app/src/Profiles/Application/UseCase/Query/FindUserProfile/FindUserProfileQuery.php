<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\FindUserProfile;

use App\Shared\Application\Query\Query;

readonly class FindUserProfileQuery extends Query
{
    public function __construct(public string $userUlid)
    {
    }
}
