<?php
declare(strict_types=1);


namespace App\Profiles\Domain\Repository;

use App\Profiles\Domain\Entity\Profile;

interface ProfileRepositoryInterface
{
    public function save(Profile $profile): void;

    public function findOneByUserUlid(string $userUlid): ?Profile;

    public function findOne(string $profileUlid): ?Profile;

    public function delete(Profile $profile): void;

}