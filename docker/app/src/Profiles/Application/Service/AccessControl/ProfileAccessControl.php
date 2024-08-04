<?php

declare(strict_types=1);

namespace App\Profiles\Application\Service\AccessControl;

use App\Profiles\Domain\Entity\Profile;
use App\Profiles\Domain\Service\ProfileFetcher;

/**
 * Служба проверки прав доступа к профилям, пока так
 */
readonly class ProfileAccessControl
{
    public function canAccess(string $userUlid, Profile $profile): bool
    {
        return $profile->isOwnedBy($userUlid);
    }
}
