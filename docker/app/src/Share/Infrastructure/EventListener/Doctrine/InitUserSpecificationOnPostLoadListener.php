<?php

declare(strict_types=1);

namespace App\Share\Infrastructure\EventListener\Doctrine;

use App\Users\Domain\Specification\UserSpecificationInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::postLoad)]
final readonly class InitUserSpecificationOnPostLoadListener
{
    public function __construct(private UserSpecificationInterface $userSpecification)
    {
    }

    public function postLoad(PostLoadEventArgs $args): void
    {
        $entity = $args->getObject();
        $reflect = new \ReflectionClass($entity);
        foreach ($reflect->getProperties() as $property) {
            $type = $property->getType();

            if (is_null($type) || $property->isInitialized($entity)) {
                continue;
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                // initialize specifications
                $interfaces = class_implements($type->getName());
                if (isset($interfaces[UserSpecificationInterface::class])) {
                    $property->setValue($entity, $this->userSpecification);
                }
            }
        }
    }
}
