<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Factory;

use App\Profiles\Domain\Entity\Profile;
use App\Profiles\Domain\Entity\Specification\ProfileSpecification;

readonly class ProfileFactory
{
    public function __construct(private ProfileSpecification $profileSpecification)
    {
    }

    public function create(
        string $name,
        ?int   $age,
        string $user_ulid,
    ): Profile
    {
        return new Profile(
            $name,
            $age,
            $user_ulid,
            $this->profileSpecification
        );
    }
}
