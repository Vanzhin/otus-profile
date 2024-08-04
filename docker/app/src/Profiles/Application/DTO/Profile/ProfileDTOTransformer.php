<?php

declare(strict_types=1);

namespace App\Profiles\Application\DTO\Profile;

use App\Profiles\Domain\Entity\Profile;

class ProfileDTOTransformer
{
    public function fromProfileEntity(Profile $profile): ProfileDTO
    {
        $dto = new ProfileDTO();
        $dto->ulid = $profile->getUlid();
        $dto->name = $profile->getName();
        $dto->age = $profile->getAge();

        return $dto;
    }

    public function fromProfileEntityList(array $entities): array
    {
        /** @var ProfileDTO[] $profiles */
        $profiles = [];
        foreach ($entities as $entity) {
            $profiles[] = $this->fromProfileEntity($entity);
        }

        return $profiles;
    }
}
