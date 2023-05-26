<?php

namespace Eastap\PhpBlog\Http\Actions\Likes;

use Eastap\PhpBlog\Http\Actions\ActionInterface;
use Eastap\PhpBlog\Interfaces\LikeRepositoryInterface;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\Response;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Blog\Like;
use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Exceptions\NoLikesException;
use Eastap\PhpBlog\UUID;

class AddLike implements ActionInterface
{
    public function __construct(
        private LikeRepositoryInterface $likeRepository
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $postUuid = $request->JsonBodyField('post_id');
            $userUuid = $request->JsonBodyField('user_id');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        if ($this->likeRepository->isLikeExists(new UUID($postUuid), new UUID($userUuid))) {
            return new ErrorResponse('Пользователь уже ставил лайк этой статье.');
        }

        $newLikeUuid = UUID::random();

        $like = new Like(
            $newLikeUuid,
            new UUID($postUuid),
            new UUID($userUuid)
        );

        try {
            $this->likeRepository->save($like);
        } catch (AppException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse([
            'result' => 'like added',
            'uuid' => (string)$newLikeUuid
        ]);
    }
}
