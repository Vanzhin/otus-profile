<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\FindProfile;

use App\Shared\Application\Query\Query;

readonly class FindProfileQuery extends Query
{
    public function __construct(public string $profileUlid, public ?string $userUlid)
    {
    }
}
