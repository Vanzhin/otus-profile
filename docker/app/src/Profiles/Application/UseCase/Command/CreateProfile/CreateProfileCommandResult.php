<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\CreateProfile;

class CreateProfileCommandResult
{
    public function __construct(
        public string $ulid,
    )
    {
    }
}
