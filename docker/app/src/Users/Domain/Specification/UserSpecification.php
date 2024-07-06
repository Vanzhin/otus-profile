<?php
declare(strict_types=1);

namespace App\Users\Domain\Specification;

class UserSpecification implements UserSpecificationInterface
{
    public function __construct(
        public EmailUserSpecification     $emailUserSpecification,
        public PasswordUserSpecification  $passwordUserSpecification,
        public UniqEmailUserSpecification $uniqEmailUserSpecification,
    )
    {
    }

}