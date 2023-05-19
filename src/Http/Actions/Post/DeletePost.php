<?php

namespace Eastap\PhpBlog\Http\Actions;

use Eastap\PhpBlog\Http\Actions\ActionInterface;
use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Interfaces\PostRepositoryInterface;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\Response;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\UUID;

class DeletePost implements ActionInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepo
    ) {}

    public function handle(Request $request): Response {

        try {
            $uuid = $request->param('uuid');
            $this->postRepo->delete(new UUID($uuid));
        } catch (AppException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse(
            [
                "result" => "post deleted",
                "uuid" => $uuid
            ]
        );
    }
}
