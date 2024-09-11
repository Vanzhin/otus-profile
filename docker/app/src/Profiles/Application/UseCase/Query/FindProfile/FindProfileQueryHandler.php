<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\FindProfile;

use App\Profiles\Application\DTO\Profile\ProfileDTOTransformer;
use App\Profiles\Application\Service\AccessControl\ProfileAccessControl;
use App\Profiles\Domain\Repository\ProfileRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Shared\Domain\Service\AssertService;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
        if (!$profile) {
            return new FindProfileQueryResult(null);
        }
        if (!$this->accessControl->canAccess($query->userUlid, $profile)) {
            throw new AccessDeniedHttpException('Access denied.');
        }
        $profileDTO = $this->profileDTOTransformer->fromProfileEntity($profile);

        return new FindProfileQueryResult($profileDTO);
    }
}
