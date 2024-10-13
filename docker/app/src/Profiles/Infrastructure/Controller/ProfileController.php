<?php

declare(strict_types=1);

namespace App\Profiles\Infrastructure\Controller;

use App\Profiles\Application\DTO\Profile\ProfileDTO;
use App\Profiles\Application\UseCase\Command\CreateProfile\CreateProfileCommand;
use App\Profiles\Application\UseCase\Command\DeleteProfile\DeleteProfileCommand;
use App\Profiles\Application\UseCase\Command\UpdateProfile\UpdateProfileCommand;
use App\Profiles\Application\UseCase\Query\FindProfile\FindProfileQuery;
use App\Profiles\Application\UseCase\Query\FindUserProfile\FindUserProfileQuery;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Domain\Service\AssertService;
use App\Shared\Domain\Service\RequestHeadersService;
use App\Shared\Infrastructure\Exception\AppException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('profile', name: 'app_api_profile_')]
class ProfileController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface     $queryBus,
        private readonly CommandBusInterface   $commandBus,
        private readonly RequestHeadersService $headersService,
    )
    {
    }
    #[Route('/my', name: 'get_my', methods: ['GET'])]
    public function getMyProfile(): JsonResponse
    {
        $userId = $this->headersService->getUserUlid();
        if (!$userId) {
            return new JsonResponse('No user ID provided.');
        }
        $query = new FindUserProfileQuery($userId);
        $result = $this->queryBus->execute($query);
        if (!$result->profileDTO) {
            return new JsonResponse('No profile found.');
        }

        return new JsonResponse($result->profileDTO);
    }

    #[Route('/{ulid}', name: 'get', methods: ['GET'])]
    public function get(string $ulid): JsonResponse
    {
        $query = new FindProfileQuery($ulid, $this->headersService->getUserUlid());
        $result = $this->queryBus->execute($query);
        if (!$result->profileDTO) {
            return new JsonResponse('No profile found.');
        }

        return new JsonResponse($result->profileDTO);
    }


    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $age = $data['age'] ?? null;
        $userUlid = $this->headersService->getUserUlid();
        AssertService::notNull($userUlid, 'No user\'s id provided.');
        if (!$name = $data['name'] ?? null) {
            throw new AppException('No name provided.');
        }
        $command = new CreateProfileCommand($name, $age ?? null, $userUlid);
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result);
    }

    #[Route('/{ulid}', name: 'delete', methods: ['DELETE'])]
    public function delete(string $ulid): JsonResponse
    {
        $command = new DeleteProfileCommand($ulid, $this->headersService->getUserUlid());
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result);
    }

    #[Route('/{ulid}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, string $ulid): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        extract($data);
        $profileDTO = new ProfileDTO();
        $profileDTO->ulid = $ulid;
        $profileDTO->name = $name ?? null;
        $profileDTO->age = $age ?? null;
        $command = new UpdateProfileCommand($profileDTO, $this->headersService->getUserUlid());
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result);
    }
}
