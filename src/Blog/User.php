<?php

namespace Eastap\PhpBlog\Blog;

class User {
  private int $id;
  private string $firstname;
  private string $lastname;

  public function __construct(int $id, string $firstname, string $lastname) {
    $this->id = $id;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
  }

  public function __toString()
  {
    return $this->firstname ." ". $this->lastname;
  }

  public function getId() {
    return $this->id;
  }

  public function getFirstName() {
    return $this->firstname;
  }

  public function getLastName() {
    return $this->lastname;
  }
}
