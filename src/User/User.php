<?php

namespace Eastap\PhpBlog\User;

use Eastap\PhpBlog\User\Name;

class User {
  private int $id;
  private string $firstname;
  private string $lastname;

  public function __construct(string $firstname, string $lastname) {
    // $this->id = $faker->unique()->numberBetween(1, 1000);
    $this->firstname = $firstname;
    $this->lastname = $lastname;
  }

  public function __toString()
  {
    return $this->firstname ." ". $this->lastname;
  }
}
