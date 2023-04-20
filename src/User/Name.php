<?php

namespace Eastap\PhpBlog\User;

class Name {
  private string $firstname;
  private string $lastname;

  public function __construct(
    $firstname,
    $lastname
  ) {
    $this->firstname = $firstname;
    $this->lastname = $lastname;
  }

  public function __toString()
  {
    return $this->firstname ." ". $this->lastname;
  }

  public function first() {
    return $this->firstname;
  }

  public function last() {
    return $this->lastname;
  }
}
