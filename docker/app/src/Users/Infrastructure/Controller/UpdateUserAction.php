<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controller;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use App\Users\Infrastructure\Service\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users/{ulid}', methods: ['PUT'])]
class UpdateUserAction extends AbstractController
{
    public function __construct(
        private UserRepository $repository,
        private UserFetcher    $userFetcher,
        private UserFactory    $factory,
    )
    {
    }

    public function __invoke(string $ulid, Request $request): JsonResponse
    {
        $user = $this->userFetcher->getUserById($ulid);
        $data = json_decode($request->getContent(), true);
        $user = $this->factory->update($user, $data['email'], $data['password']);
        $this->repository->add($user);

        return new JsonResponse('User updated successfully.');
    }
}
