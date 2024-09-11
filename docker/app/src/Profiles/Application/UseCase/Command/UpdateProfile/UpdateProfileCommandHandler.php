<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\UpdateProfile;

use App\Profiles\Application\Service\AccessControl\ProfileAccessControl;
use App\Profiles\Domain\Repository\ProfileRepositoryInterface;
use App\Profiles\Domain\Service\ProfileFetcher;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Service\AssertService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

readonly class UpdateProfileCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProfileFetcher             $profileFetcher,
        private ProfileRepositoryInterface $profileRepository,
        private ProfileAccessControl       $accessControl,
    )
    {
    }

    public function __invoke(UpdateProfileCommand $command): UpdateProfileCommandResult
    {
        $profile = $this->profileFetcher->getRequiredProfile($command->profileDTO->ulid);
        if (!$this->accessControl->canAccess($command->userUlid, $profile)) {
            throw new AccessDeniedHttpException('Access denied.');
        }
        $profile->setName($command->profileDTO->name);
        $profile->setAge($command->profileDTO->age);
        $this->profileRepository->save($profile);

        return new UpdateProfileCommandResult(
            $profile->getUlid(),
        );
    }
}
