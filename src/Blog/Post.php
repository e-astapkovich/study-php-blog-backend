<?php

namespace Eastap\PhpBlog\Blog;

use Eastap\PhpBlog\UUID;

class Post {
  private UUID $uuid;
  private USER $author;
  private string $title;
  private string $text;

  public function __construct(
    UUID $uuid,
    User $author,
    string $title,
    string $text
  ) {
    $this->uuid = $uuid;
    $this->author = $author;
    $this->title = $title;
    $this->text = $text;
  }

  public function __toString() {
    return "Автор: $this->author\nЗаголовок: $this->title\n$this->text";
  }

  public function getId() {
    return $this->uuid;
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
