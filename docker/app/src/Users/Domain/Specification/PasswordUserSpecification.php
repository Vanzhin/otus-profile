<?php
declare(strict_types=1);


namespace App\Users\Domain\Specification;

use App\Share\Domain\Service\ValidationService;
use App\Share\Domain\Specification\SpecificationInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordUserSpecification implements SpecificationInterface
{
    public function __construct(private ValidationService $validation)
    {
    }

    public function satisfy(string $password): void
    {
        $constraint = [
            new Length([
                'min' => 8,
                'max' => 20
            ]),
            new NotBlank(),
        ];
        $errors = $this->validation->validate($password, ...$constraint);

        if ($errors) {
            throw new \Exception("Password: " . implode('; ', $errors));
        }
    }
}