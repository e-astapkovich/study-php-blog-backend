<?php

namespace Eastap\PhpBlog\Blog;

use Eastap\PhpBlog\User\Name;

class User {
  private int $id;
  private string $firstname;
  private string $lastname;

  public function __construct(int $id, string $firstname, string $lastname) {
    // $this->id = $faker->unique()->numberBetween(1, 1000);
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
}
