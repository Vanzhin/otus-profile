<?php
declare(strict_types=1);


namespace App\Profiles\Domain\Entity\Specification;

use App\Shared\Domain\Specification\SpecificationInterface;

readonly class ProfileSpecification implements SpecificationInterface
{
    public function __construct(public ProfileAgeLimitSpecification $ageLimitSpecification)
    {
    }

}