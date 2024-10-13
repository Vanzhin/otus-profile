<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\FindUserProfile;

use App\Profiles\Application\DTO\Profile\ProfileDTOTransformer;
use App\Profiles\Domain\Repository\ProfileRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

readonly class FindUserProfileQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private ProfileDTOTransformer      $profileDTOTransformer,
    )
    {
    }

    public function __invoke(FindUserProfileQuery $query): FindUserProfileQueryResult
    {
        $profile = $this->profileRepository->findOneByUserUlid($query->userUlid);
        if (!$profile) {
            return new FindUserProfileQueryResult(null);
        }
        $profileDTO = $this->profileDTOTransformer->fromProfileEntity($profile);

        return new FindUserProfileQueryResult($profileDTO);
    }
}
