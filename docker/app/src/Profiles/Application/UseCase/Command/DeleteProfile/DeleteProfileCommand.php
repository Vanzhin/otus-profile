<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\DeleteProfile;

use App\Shared\Application\Command\Command;

readonly class DeleteProfileCommand extends Command
{
    public function __construct(
        public string $ulid,
        public string $userUlid,
    )
    {
    }
}
