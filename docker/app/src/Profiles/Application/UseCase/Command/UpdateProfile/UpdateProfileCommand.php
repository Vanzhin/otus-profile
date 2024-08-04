<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\UpdateProfile;

use App\Profiles\Application\DTO\Profile\ProfileDTO;
use App\Shared\Application\Command\Command;

readonly class UpdateProfileCommand extends Command
{
    public function __construct(
        public ProfileDTO $profileDTO,
        public string     $userUlid,
    )
    {
    }
}
