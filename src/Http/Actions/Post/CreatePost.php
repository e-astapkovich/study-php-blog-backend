<?php

namespace Eastap\PhpBlog\Http\Actions\Post;

use Eastap\PhpBlog\Http\Actions\ActionInterface;
use Eastap\PhpBlog\Repositories\SqlitePostRepository;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Blog\Post;
use Eastap\PhpBlog\Http\Auth\IdentificationInterface;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\Response;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\UUID;
use Psr\Log\LoggerInterface;

class CreatePost implements ActionInterface
{
    public function __construct(
        private SqlitePostRepository $postRepo,
        private IdentificationInterface $identification,
        private LoggerInterface $logger
    ){}

    public function handle(Request $request): Response {

        $author = $this->identification->user($request);

        try {
            $title = $request->JsonBodyField('title');
            $text = $request->JsonBodyField('text');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $newPostUuid = UUID::random();

        $post = new Post(
            $newPostUuid,
            $author->getId(),
            $title,
            $text
        );

        try {
            $this->postRepo->save($post);
            $this->logger->info("Post created: $newPostUuid");
        } catch (AppException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse([
            'result' => 'post created',
            'uuid' => (string)$newPostUuid
        ]);
    }
}
