<?php

namespace Eastap\PhpBlog\Repositories;

use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\Exceptions\UserNotFoundException;
use Eastap\PhpBlog\UUID;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use \PDO;
use PDOStatement;

class SqliteUserRepository implements UserRepositoryInterface
{
  private PDO $pdo;
  private LoggerInterface $logger;

  public function __construct(
    PDO $pdo,
    LoggerInterface $logger
    )
  {
    $this->pdo = $pdo;
    $this->logger = $logger;
  }

  public function save(User $user): void
  {
    $statement = $this->pdo->prepare("INSERT INTO `users` (`uuid`, `login`, `first_name`, `last_name`) VALUES (:uuid, :login, :firstName, :lastName)");
    $userUuid = $user->getId();
    $statement->execute([
      ':uuid' => $userUuid,
      ':login' => $user->getLogin(),
      ':firstName' => $user->getFirstName(),
      ':lastName' => $user->getLastName()
    ]);
    $this->logger->info("User saved to sqlite db: $userUuid");
  }

  public function get(UUID $uuid): User
  {
    $statement = $this->pdo->prepare("SELECT * FROM `users` WHERE `uuid` = ?");
    $statement->execute([(string)$uuid]);
    return $this->getUser($statement);
  }

  public function getByLogin(string $login): User
  {
    $statement = $this->pdo->prepare("SELECT * FROM `users` WHERE `login` = ?");
    $statement->execute([$login]);
    return $this->getUser($statement);
  }

  private function getUser(PDOStatement $statement): User
  {
    $user = $statement->fetch();
    if ($user == false) {
      $this->logger->warning("User not foun in db");
      throw new UserNotFoundException('Пользователь не найден');
    }
    return new User(new UUID($user['uuid']), $user['login'], $user['first_name'], $user['last_name']);
  }
}
