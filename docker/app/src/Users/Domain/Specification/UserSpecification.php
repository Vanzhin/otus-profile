<?php
declare(strict_types=1);

namespace App\Users\Domain\Specification;

use App\Share\Domain\Specification\SpecificationInterface;

class UserSpecification implements SpecificationInterface
{
    public function __construct(
        public EmailUserSpecification     $emailUserSpecification,
        public PasswordUserSpecification  $passwordUserSpecification,
        public UniqEmailUserSpecification $uniqEmailUserSpecification,
    )
    {
    }

}