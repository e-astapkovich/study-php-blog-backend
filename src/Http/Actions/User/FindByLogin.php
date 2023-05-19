<?php

namespace Eastap\PhpBlog\Http\Actions\User;

use Eastap\PhpBlog\Http\Actions\ActionInterface;
use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\Http\Response;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Http\SuccessResponse;

class FindByLogin implements ActionInterface
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $login = $request->param('login');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $user = $this->repository->getByLogin($login);
        } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse([
            'login' => $user->getLogin(),
            'name' => $user->getFirstName() . " " . $user->getLastName()
        ]);
    }
}
