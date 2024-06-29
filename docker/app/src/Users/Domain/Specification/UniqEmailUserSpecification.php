<?php
declare(strict_types=1);


namespace App\Users\Domain\Specification;

use App\Share\Domain\Specification\SpecificationInterface;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Repository\UserRepositoryInterface;


readonly class UniqEmailUserSpecification implements SpecificationInterface
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function satisfy(User $user): void
    {
        if ($this->repository->getByEmail($user->getEmail())) {
            throw new \Exception("User with this email exists already.");
        };
    }
}