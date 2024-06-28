<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Domain\Users\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    protected UserRepository $users;

    public function __construct(LoggerInterface $logger, UserRepository $eventRepository)
    {
        parent::__construct($logger);
        $this->users = $eventRepository;
    }
}
