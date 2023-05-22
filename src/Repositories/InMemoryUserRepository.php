<?php

namespace Eastap\PhpBlog\Repositories;

use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\UUID;

class InMemoryUserRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function get(UUID $uuid): User
    {
        foreach ($this->users as $user) {
            if ((string)$user->uuid == (string)$uuid) {
                return $user;
            }
        }
        throw new UserNotFoundException("Пользователь с UUID $uuid не найден.");
    }

    public function getByLogin(string $login): User
    {
        foreach ($this->users as $user) {
            if ($user->login == $login) {
                return $user;
            }
        }
        throw new UserNotFoundException("Пользователь с логином $login не найден.");
    }
}
