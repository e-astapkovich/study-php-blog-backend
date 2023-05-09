<?php

namespace Eastap\PhpBlog\Commands;

use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Exceptions\CommandException;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\Commands\Arguments;
use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\UUID;

class CreateUserCommand
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function handle(Arguments $arguments): void
    {
        $login = $arguments->get('login');
        if ($this->userExists($login)) {
            throw new CommandException("User already exists: $login");
        }

        $user = new User(
            UUID::random(),
            $arguments->get('login'),
            $arguments->get('first_name'),
            $arguments->get('last_name')

        );
        $this->userRepository->save($user);
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
