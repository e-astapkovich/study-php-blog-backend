<?php

namespace Eastap\PhpBlog\Repositories;

use PDO;
use Eastap\PhpBlog\Blog\Like;
use Eastap\PhpBlog\Exceptions\NoLikesException;
use Eastap\PhpBlog\Interfaces\LikeRepositoryInterface;
use Eastap\PhpBlog\UUID;
use Psr\Log\LoggerInterface;

class SqliteLikeRepository implements LikeRepositoryInterface
{
    public function __construct(
        private PDO $pdo,
        private LoggerInterface $logger
    ) {}

    public function save(Like $like): void {

        $uuid = $like->getUuid();
        $postUuid = $like->getPostUuid();
        $userUuid = $like->getUserUuid();

        $statement = $this->pdo->prepare("INSERT INTO `likes` (uuid, post_uuid, user_uuid) VALUES (:uuid, :post_uuid, :user_uuid)");
        $statement->execute([
            ':uuid' => $uuid,
            ':post_uuid' => $postUuid,
            ':user_uuid' => $userUuid
        ]);
        $this->logger->info("Like saved to sqlite db: $uuid");
    }

    public function getByPostUuid(UUID $postUuid): array {

        $statement = $this->pdo->prepare("SELECT * FROM `likes` WHERE `post_uuid`=:post_uuid");
        $statement->execute([':post_uuid' => (string)$postUuid]);
        $result = $statement->fetchAll();
        if ($result == false) {
            throw new NoLikesException("Post $postUuid has no likes");
        }
        return $result;
    }

    public function isLikeExists(UUID $postUuid, UUID $userUuid): bool {
        $statement = $this->pdo->prepare("SELECT * FROM `likes` WHERE `post_uuid`=:post_uuid AND `user_uuid`=:user_uuid");
        $statement->execute([
            ':post_uuid' => $postUuid,
            ':user_uuid' => $userUuid
        ]);
        $result = $statement->fetchAll();
        return (bool)$result;
    }
}
