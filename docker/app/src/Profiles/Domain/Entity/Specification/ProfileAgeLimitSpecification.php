<?php
declare(strict_types=1);


namespace App\Profiles\Domain\Entity\Specification;

use App\Profiles\Domain\Entity\Profile;
use App\Shared\Domain\Service\AssertService;
use App\Shared\Domain\Specification\SpecificationInterface;

class ProfileAgeLimitSpecification implements SpecificationInterface
{
    public function satisfy(Profile $profile): void
    {
        if ($profile->getAge()) {
            AssertService::range(
                $profile->getAge(),
                18,
                150,
                'It is not allowed for persons under 18');
        }
    }
}