<?php
declare(strict_types=1);

namespace App\Profiles\Infrastructure\MessageHandler;


use App\Profiles\Application\UseCase\Command\CreateProfile\CreateProfileCommand;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Message\MessageHandlerInterface;
use App\Shared\Domain\Message\ExternalMessage;

final readonly class ExternalMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    )
    {
    }

    public function __invoke(ExternalMessage $message)
    {
        if ($message->getEventType() === 'user_created') {
            $command = new CreateProfileCommand(
                $message->getEventData()['name'],
                $message->getEventData()['age'],
                $message->getEventData()['user_id'],
            );
            $this->commandBus->execute($command);
        }
    }
}