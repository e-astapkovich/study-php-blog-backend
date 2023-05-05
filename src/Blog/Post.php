<?php

namespace Eastap\PhpBlog\Blog;

use Eastap\PhpBlog\UUID;

class Post {
  private UUID $uuid;
  private UUID $authorId;
  private string $title;
  private string $text;

  public function __construct(
    UUID $uuid,
    UUID $authorId,
    string $title,
    string $text
  ) {
    $this->uuid = $uuid;
    $this->authorId = $authorId;
    $this->title = $title;
    $this->text = $text;
  }

  public function __toString() {
    return "Заголовок: $this->title\n$this->text";
  }

  public function getId() {
    return $this->uuid;
  }

  public function getAuthorId() {
    return $this->authorId;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getText() {
    return $this->text;
  }
}
