<?php

namespace Eastap\PhpBlog\Blog;

class Post {
  private $id;
  private $author;
  private $title;
  private $text;

  public function __construct(
    int $id,
    User $author,
    string $title,
    string $text
  ) {
    $this->id = $id;
    $this->author = $author;
    $this->title = $title;
    $this->text = $text;
  }

  public function __toString() {
    return "Автор: $this->author\nЗаголовок: $this->title\n$this->text";
  }

  public function getId() {
    return $this->id;
  }

  public function getAuthor() {
    return $this->author;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getText() {
    return $this->text;
  }
}
