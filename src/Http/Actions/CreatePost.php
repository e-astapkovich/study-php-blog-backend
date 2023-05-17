<?php

namespace Eastap\PhpBlog\Http\Actions;

use Eastap\PhpBlog\Blog\Post;
use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\Response;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\Http\Actions\ActionInterface;
use Eastap\PhpBlog\Repositories\SqlitePostRepository;
use Eastap\PhpBlog\Repositories\SqliteUserRepository;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\UUID;

class CreatePost implements ActionInterface
{
    public function __construct(
        private SqlitePostRepository $postRepo,
    ){}

    public function handle(Request $request): Response {

        try {
            $authorId = $request->JsonBodyField('authorId');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $title = $request->JsonBodyField('title');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $text = $request->JsonBodyField('text');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $post = new Post(
            UUID::random(),
            new UUID($authorId),
            $title,
            $text
        );

        try {
            $this->postRepo->save($post);
        } catch (AppException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse(['result' => 'post created']);
    }
}
