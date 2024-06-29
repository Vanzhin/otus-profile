<?php
declare(strict_types=1);


namespace App\Users\Domain\Specification;

use App\Share\Domain\Service\ValidationService;
use App\Share\Domain\Specification\SpecificationInterface;
use App\Users\Domain\Entity\User;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

readonly class EmailUserSpecification implements SpecificationInterface
{
    public function __construct(private ValidationService $validation)
    {
    }

    public function satisfy(User $user): void
    {
        $constraint = [new NotBlank(), new Email(), new NotNull()];
        $errors = $this->validation->validate($user->getEmail(), ...$constraint);

        if ($errors) {
            throw new \Exception("Email: " . implode('; ', $errors));
        }
    }
}