<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controller;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api/users', methods: ['POST'])]
class AddUserAction extends AbstractController
{
    public function __construct(
        private UserRepository $repository,
        private UserFactory    $factory,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->factory->create($data['email'], $data['password']);
        $this->repository->add($user);

        return new JsonResponse(['user_id' => $user->getUlid()]);
    }
}
