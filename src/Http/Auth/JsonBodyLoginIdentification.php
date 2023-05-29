<?php

namespace Eastap\PhpBlog\Http\Auth;

use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\Exceptions\AuthException;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Exceptions\InvalidArgumentException;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;

class JsonBodyLoginIdentification implements IdentificationInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function user(Request $request): User {
        try {
            $login = $request->JsonBodyField('login');
        } catch(HttpException|InvalidArgumentException $e) {
            throw new AuthException($e->getMessage());
        }

        try {
            return $this->userRepository->getByLogin($login);
        } catch(UserNotFoundException $e) {
            throw new AuthException($e->getMessage());
        }
    }
}
