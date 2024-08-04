<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\DeleteProfile;

class DeleteProfileCommandResult
{
    public function __construct(
        public string $ulid,
    )
    {
    }
}
