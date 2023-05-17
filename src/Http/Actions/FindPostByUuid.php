<?php

namespace Eastap\PhpBlog\Http\Actions;

use Eastap\PhpBlog\Http\Actions\ActionInterface;
use Eastap\PhpBlog\Interfaces\PostRepositoryInterface;
use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Http\Response;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Exceptions\PostNotFoundException;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\UUID;

class FindPostByUuid implements ActionInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepo,
        private UserRepositoryInterface $userRepo
        )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $uuid = $request->param('uuid');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $post = $this->postRepo->get(new UUID($uuid));
        } catch (PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $author = $this->userRepo->get(new UUID($post->getAuthorId()));
            $name = $author->getFirstName() . " " . $author->getLastName();
        } catch (UserNotFoundException $e) {
            $author = 'Неизвестный автор';
        }

        return new SuccessResponse([
            'author' => $name,
            'title' => $post->getTitle(),
            'text' => $post->getText()
        ]);
    }
}
