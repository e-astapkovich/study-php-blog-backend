<?php

namespace Eastap\PhpBlog\Repositories;

use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\UUID;
use \PDO;
use PDOStatement;

class SqliteUserRepository implements UserRepositoryInterface
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function save(User $user): void
  {
    $statement = $this->pdo->prepare("INSERT INTO `users` (`uuid`, `login`, `first_name`, `last_name`) VALUES (:uuid, :login, :firstName, :lastName)");
    $statement->execute([
      ':uuid' => $user->getId(),
      ':login' => $user->getLogin(),
      ':firstName' => $user->getFirstName(),
      ':lastName' => $user->getLastName()
    ]);
  }

  public function get(UUID $uuid): User
  {
    echo "function get" . PHP_EOL; // debug
    $statement = $this->pdo->prepare("SELECT * FROM `users` WHERE `uuid` = ?");
    $statement->execute([(string)$uuid]);
    return $this->getUser($statement);
  }

  public function getByLogin(string $login): User
  {
    echo "function getByLogin" . PHP_EOL; // debug
    $statement = $this->pdo->prepare("SELECT * FROM `users` WHERE `login` = ?");
    $statement->execute([$login]);
    return $this->getUser($statement);
  }

  private function getUser(PDOStatement $statement): User
  {
    $user = $statement->fetch();
    if ($user == false) {
      throw new UserNotFoundException('Пользователь не найден');
    }
    return new User(new UUID($user['uuid']), $user['login'], $user['first_name'], $user['last_name']);
  }
}
