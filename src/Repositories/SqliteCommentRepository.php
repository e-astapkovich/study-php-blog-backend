<?php

namespace Eastap\PhpBlog\Repositories;

use Eastap\PhpBlog\Interfaces\CommentRepositoryInterface;
use Eastap\PhpBlog\Exceptions\CommentNotFoundException;
use Eastap\PhpBlog\Blog\Comment;
use Eastap\PhpBlog\UUID;
use Psr\Log\LoggerInterface;
use \PDO;

class SqliteCommentRepository implements CommentRepositoryInterface
{
  private PDO $pdo;
  private LoggerInterface $logger;

  public function __construct(
    PDO $pdo,
    LoggerInterface $logger)
  {
    $this->pdo = $pdo;
    $this->logger = $logger;
  }

  public function save(Comment $comment): void
  {
    $statement = $this->pdo->prepare('INSERT INTO `comments` (`uuid`, `post_uuid`, `author_uuid`, `text`) VALUES (:uuid, :post_uuid, :author_uuid, :text)');
    $commentUuid = $comment->getId();
    $statement->execute([
      ':uuid' => $commentUuid,
      ':post_uuid' => $comment->getPostId(),
      ':author_uuid' => $comment->getUserId(),
      ':text' => $comment->getText()
    ]);
    $this->logger->info("Comment saved to sqlite db: $commentUuid");
  }

  public function get(UUID $id): Comment
  {
    $statement = $this->pdo->prepare('SELECT * FROM `comments` WHERE `uuid`=?');
    $statement->execute([$id]);
    $result = $statement->fetch();
    if ($result == false) {
      $this->logger->warning("Comment not found in db: $id");
      throw new CommentNotFoundException("Коммент не найден");
    }
    return new Comment(
      new UUID($result['uuid']),
      new UUID($result['post_uuid']),
      new UUID($result['author_uuid']),
      $result['text']
    );
  }
}
