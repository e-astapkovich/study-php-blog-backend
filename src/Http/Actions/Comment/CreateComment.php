<?php

namespace Eastap\PhpBlog\Http\Actions\Comment;

use Eastap\PhpBlog\Http\Actions\ActionInterface;
use Eastap\PhpBlog\Blog\Comment;
use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\Response;
use Eastap\PhpBlog\Interfaces\CommentRepositoryInterface;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\UUID;
use ErrorException;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepo
    ) {}

    public function handle(Request $request): Response {
        try {
            $authorUuid = $request->JsonBodyField('author_uuid');
            $postUuid = $request->JsonBodyField('post_uuid');
            $text = $request->JsonBodyField('text');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $newCommentUuid = UUID::random();

        $comment = new Comment(
            $newCommentUuid,
            new UUID($postUuid),
            new UUID($authorUuid),
            $text
        );

        try {
            $this->commentRepo->save($comment);
        } catch(AppException $e) {
            return new ErrorException($e->getMessage());
        }

        return new SuccessResponse(
            [
                "result" => "comment created",
                "uuid" => "$newCommentUuid"
            ]
        );
    }

}
