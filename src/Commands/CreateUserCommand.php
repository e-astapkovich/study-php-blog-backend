<?php

namespace Eastap\PhpBlog\Commands;

use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Exceptions\CommandException;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\Commands\Arguments;
use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\UUID;
use Psr\Log\LoggerInterface;

class CreateUserCommand
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger
    ) {
    }

    public function handle(Arguments $arguments): void
    {
        $this->logger->info('Create user command started.');
        $login = $arguments->get('login');
        if ($this->userExists($login)) {
            $this->logger->warning("User already exists: $login");
            return;
        }

        $uuid = UUID::random();

        $user = new User(
            $uuid,
            $arguments->get('login'),
            $arguments->get('first_name'),
            $arguments->get('last_name')

        );
        $this->userRepository->save($user);

        $this->logger->info("New user created: $uuid");
    }

    public function userExists(string $login): bool
    {
        try {
            $this->userRepository->getByLogin($login);
        } catch (UserNotFoundException) {
            return false;
        }
        return true;
    }
}
