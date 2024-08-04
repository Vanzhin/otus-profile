<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\CreateProfile;


use App\Profiles\Domain\Factory\ProfileFactory;
use App\Profiles\Domain\Repository\ProfileRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Service\AssertService;

readonly class CreateProfileCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProfileFactory             $profileFactory,
        private ProfileRepositoryInterface $profileRepository,
    )
    {
    }

    public function __invoke(CreateProfileCommand $command): CreateProfileCommandResult
    {
        AssertService::null(
            $this->profileRepository->findOneByUserUlid($command->userUlid),
            'This user has profile already.'
        );
        $profile = $this->profileFactory->create(
            $command->name,
            $command->age,
            $command->userUlid,
        );
        $this->profileRepository->save($profile);

        return new CreateProfileCommandResult(
            $profile->getUlid()
        );
    }
}
