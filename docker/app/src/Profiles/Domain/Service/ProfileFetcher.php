<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Service;

use App\Profiles\Domain\Entity\Profile;
use App\Profiles\Domain\Repository\ProfileRepositoryInterface;
use Webmozart\Assert\Assert;

readonly class ProfileFetcher
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
    )
    {
    }

    public function getRequiredProfile(string $profileUlid): Profile
    {
        $profile = $this->profileRepository->findOne($profileUlid);
        Assert::notNull($profile, 'No profile found.');

        return $profile;
    }
}
