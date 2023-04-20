<?php

// На данном этапе класс не использую.
// Его функционал почти полностью дублируется с классом User
// Пока не удаляю - возможно пригодится в будущем

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
