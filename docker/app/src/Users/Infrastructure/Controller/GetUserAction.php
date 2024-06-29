<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controller;

use App\Users\Domain\Service\UserFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users/{ulid}', methods: ['GET'])]
class GetUserAction extends AbstractController
{
    public function __construct(private UserFetcherInterface $userFetcher)
    {
    }

    public function __invoke(string $ulid): JsonResponse
    {
        $user = $this->userFetcher->getUserById($ulid);

        return new JsonResponse([
            'id' => $user->getUlid(),
            'roles' => $user->getRoles(),
            'email' => $user->getEmail(),
        ]);
    }
}
