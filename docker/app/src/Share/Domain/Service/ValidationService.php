<?php

declare(strict_types=1);

namespace App\Share\Domain\Service;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validation;

class ValidationService
{
    static public function validate(mixed $data, Constraint ...$constraint): array
    {
        $validator = Validation::createValidator();
        $errors = $validator->validate($data, $constraint);

        $errorMessage = [];
        foreach ($errors as $error) {
            if (0 !== $errors->count()) {
                $errorMessage[] = $error->getMessage();
            }
        }

        return $errorMessage;
    }
}
