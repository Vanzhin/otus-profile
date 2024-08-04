<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\UpdateProfile;

class UpdateProfileCommandResult
{
    public function __construct(
        public string $ulid,
    )
    {
    }
}
