<?php
declare(strict_types=1);


namespace App\Profiles\Infrastructure\Repository;

use App\Profiles\Domain\Entity\Profile;
use App\Profiles\Domain\Repository\ProfileRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProfileRepository extends ServiceEntityRepository implements ProfileRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    #[\Override] public function save(Profile $profile): void
    {
        $this->getEntityManager()->persist($profile);
        $this->getEntityManager()->flush();
    }

    #[\Override] public function findOneByUserUlid(string $userUlid): ?Profile
    {
        return $this->findOneBy(['user_ulid' => $userUlid]);
    }

    #[\Override] public function findOne(string $profileUlid): ?Profile
    {
        return $this->findOneBy(['ulid' => $profileUlid]);
    }

    #[\Override] public function delete(Profile $profile): void
    {
        $this->getEntityManager()->remove($profile);
        $this->getEntityManager()->flush();
    }
}