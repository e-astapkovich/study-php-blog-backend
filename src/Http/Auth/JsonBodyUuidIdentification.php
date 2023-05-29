<?php

namespace Eastap\PhpBlog\Http\Auth;

use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Exceptions\InvalidArgumentException;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Exceptions\AuthException;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\UUID;

class JsonBodyUuidIdentification implements IdentificationInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function user(Request $request): User
    {
        try {
            $userUuid = new UUID($request->JsonBodyField('author_uuid'));
        } catch (HttpException|InvalidArgumentException $e) {
            throw new AuthException($e->getMessage());
        }

        try {
            return $this->userRepository->get($userUuid);
        } catch (UserNotFoundException $e) {
            throw new AuthException($e->getMessage());
        }
    }
}
