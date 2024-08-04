<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Entity;

use App\Profiles\Domain\Entity\Specification\ProfileSpecification;
use App\Shared\Domain\Service\UlidService;

class Profile
{
    private readonly string $ulid;
    private ?int $age;

    public function __construct(
        private string                        $name,
        ?int                                  $age,
        private readonly string               $user_ulid,
        private readonly ProfileSpecification $profileSpecification,
    )
    {
        $this->ulid = UlidService::generate();
        $this->setAge($age);
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getUserUlid(): string
    {
        return $this->user_ulid;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAge(?int $age): void
    {
        $this->age = $age;
        $this->profileSpecification->ageLimitSpecification->satisfy($this);
    }

    public function isOwnedBy(string $userUlid): bool
    {
        return $this->user_ulid === $userUlid;
    }
}
