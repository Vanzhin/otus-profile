<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\CreateProfile;

use App\Shared\Application\Command\Command;

readonly class CreateProfileCommand extends Command
{
    public function __construct(
        public string $name,
        public ?int   $age,
        public string $userUlid,
    )
    {
    }
}
