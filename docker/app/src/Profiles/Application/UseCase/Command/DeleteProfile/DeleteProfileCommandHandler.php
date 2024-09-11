<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\DeleteProfile;

use App\Profiles\Application\Service\AccessControl\ProfileAccessControl;
use App\Profiles\Domain\Repository\ProfileRepositoryInterface;
use App\Profiles\Domain\Service\ProfileFetcher;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Service\AssertService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

readonly class DeleteProfileCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private ProfileFetcher             $profileFetcher,
        private ProfileAccessControl       $accessControl
    )
    {
    }

    public function __invoke(DeleteProfileCommand $command): DeleteProfileCommandResult
    {
        $profile = $this->profileFetcher->getRequiredProfile($command->ulid);
        if (!$this->accessControl->canAccess($command->userUlid, $profile)) {
            throw new AccessDeniedHttpException('Access denied.');
        }
        $this->profileRepository->delete($profile);

        return new DeleteProfileCommandResult($profile->getUlid());
    }
}
