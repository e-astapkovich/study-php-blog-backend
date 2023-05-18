<?php

namespace Eastap\PhpBlog\Repositories;

use Eastap\PhpBlog\Interfaces\PostRepositoryInterface;
use Eastap\PhpBlog\Exceptions\PostNotFoundException;
use Eastap\PhpBlog\Blog\Post;
use Eastap\PhpBlog\UUID;
use \PDO;

class SqlitePostRepository implements PostRepositoryInterface
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function save(Post $post): void
  {
    $statement = $this->pdo->prepare('INSERT INTO `posts` (`uuid`, `author_uuid`, `title`, `text`) VALUES (:uuid, :author_uuid, :title, :text)');
    $statement->execute([
      ':uuid' => (string)$post->getId(),
      ':author_uuid' => (string)$post->getAuthorId(),
      ':title' => $post->getTitle(),
      ':text' => $post->getText()
    ]);
  }

  public function get(UUID $uuid): Post
  {
    $statement = $this->pdo->prepare('SELECT * FROM `posts` WHERE `uuid`=?');
    $statement->execute([(string)$uuid]);
    $result = $statement->fetch();
    if ($result == false) {
      throw new PostNotFoundException('Пост не найден');
    }
    return new Post(new UUID($result['uuid']), new UUID($result['author_uuid']), $result['title'], $result['text']);
  }

  public function delete(UUID $uuid): void {
    $statement = $this->pdo->prepare('DELETE FROM `posts` WHERE `uuid`=:uuid');
    $statement->execute([':uuid' => (string)$uuid]);
  }
}
