<?php

namespace Eastap\PhpBlog\Http\Actions\Post;

use Eastap\PhpBlog\Http\Actions\ActionInterface;
use Eastap\PhpBlog\Repositories\SqlitePostRepository;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Blog\Post;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\Response;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\UUID;
use PSR\Log\LoggerInterface;

class CreatePost implements ActionInterface
{
    public function __construct(
        private SqlitePostRepository $postRepo,
        private LoggerInterface $logger
    ){}

    public function handle(Request $request): Response {

        try {
            $authorUuid = $request->JsonBodyField('author_uuid');
            $title = $request->JsonBodyField('title');
            $text = $request->JsonBodyField('text');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $newPostUuid = UUID::random();

        $post = new Post(
            $newPostUuid,
            new UUID($authorUuid),
            $title,
            $text
        );

        try {
            $this->postRepo->save($post);
            $this->logger->info("Postcreated: $newPostUuid");
        } catch (AppException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse([
            'result' => 'post created',
            'uuid' => (string)$newPostUuid
        ]);
    }
}
