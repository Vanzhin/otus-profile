<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controller;

use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\Service\UserFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users/{ulid}', methods: ['DELETE'])]
class DeleteUserAction extends AbstractController
{
    public function __construct(private UserFetcherInterface $userFetcher, private UserRepositoryInterface $repository)
    {
    }

    public function __invoke(string $ulid): JsonResponse
    {
        $user = $this->userFetcher->getUserById($ulid);
        $this->repository->delete($user);

        return new JsonResponse("User was deleted.");
    }
}
