<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\FindProfile;

use App\Profiles\Application\DTO\Profile\ProfileDTOTransformer;
use App\Profiles\Application\Service\AccessControl\ProfileAccessControl;
use App\Profiles\Domain\Repository\ProfileRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Shared\Domain\Service\AssertService;

readonly class FindProfileQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private ProfileDTOTransformer      $profileDTOTransformer,
        private ProfileAccessControl       $accessControl,
    )
    {
    }

    public function __invoke(FindProfileQuery $query): FindProfileQueryResult
    {
        $profile = $this->profileRepository->findOne($query->profileUlid);
        AssertService::true(
            $this->accessControl->canAccess($query->userUlid, $profile),
            'Access denied.'
        );
        if (!$profile) {
            return new FindProfileQueryResult(null);
        }
        $profileDTO = $this->profileDTOTransformer->fromProfileEntity($profile);

        return new FindProfileQueryResult($profileDTO);
    }
}
