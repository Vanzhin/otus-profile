<?php

declare(strict_types=1);

namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Domain\Specification\UserSpecification;

readonly class UserFactory
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private UserSpecification           $specification,
    )
    {
    }

    public function create(string $email, ?string $password): User
    {
        $user = new User($email, $this->specification);
        $user->setPassword($password, $this->hasher);

        return $user;
    }

    public function update(User $user, ?string $email, ?string $password): User
    {
        if ($email) {
            $user->setEmail($email);
        }
        if ($password) {
            $user->setPassword($password, $this->hasher);
        }

        return $user;
    }
}
