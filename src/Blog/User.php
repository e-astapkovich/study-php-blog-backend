<?php

namespace Eastap\PhpBlog\Blog;

use Eastap\PhpBlog\UUID;

class User {
  private UUID $uuid;
  private string $login; // В методичке используется название $username. Но мне показалось, что $login понятней.
  private string $firstname;
  private string $lastname;

  public function __construct(UUID $uuid, string $login, string $firstname, string $lastname) {
    $this->uuid = $uuid;
    $this->login = $login;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
  }

  public function __toString()
  {
    return "Пользователь $this->firstname $this->lastname с id: $this->uuid и логином $this->login";
  }

  public function getId() {
    return $this->uuid;
  }

  public function getLogin() {
    return $this->login;
  }

  public function getFirstName() {
    return $this->firstname;
  }

  public function getLastName() {
    return $this->lastname;
  }
}
