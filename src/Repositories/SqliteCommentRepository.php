<?php

namespace Eastap\PhpBlog\Repositories;

use Eastap\PhpBlog\Interfaces\CommentRepositoryInterface;
use Eastap\PhpBlog\Blog\Comment;
use Eastap\PhpBlog\UUID;
use \PDO;

class SqliteCommentRepository implements CommentRepositoryInterface
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function save(Comment $comment): void
  {
    $statement = $this->pdo->prepare('INSERT INTO `comments` (`uuid`, `post_uuid`, `author_uuid`, `text`) VALUES (:uuid, :post_uuid, :author_uuid, :text)');
    $statement->execute([
      ':uuid' => $comment->getId(),
      ':post_uuid' => $comment->getPostId(),
      ':author_uuid' => $comment->getUserId(),
      ':text' => $comment->getText()
    ]);
  }

  public function get(UUID $id): Comment
  {
    $statement = $this->pdo->prepare('SELECT * FROM `comments` WHERE `uuid`=?');
    $statement->execute([$id]);
    $result = $statement->fetch();
    return new Comment(
      new UUID($result['uuid']),
      new UUID($result['post_uuid']),
      new UUID($result['author_uuid']),
      $result['text']
    );
  }
}
