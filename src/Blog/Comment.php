<?php

namespace Eastap\PhpBlog\Blog;

use Eastap\PhpBlog\UUID;

class Comment {
  private UUID $uuid;
  private UUID $postId;
  private UUID $userId;
  private string $text;

  public function __construct($uuid, $postId, $userId, $text) {
    $this->uuid = $uuid;
    $this->postId = $postId;
    $this->userId = $userId;
    $this->text = $text;
  }

  public function __toString()
  {
    return "Комментарий: $this->text";
  }

  public function getId() {
    return $this->uuid;
  }

  public function getPostId() {
    return $this->postId;
  }

  public function getUserId() {
    return $this->userId;
  }

  public function getText() {
    return $this->text;
  }
}
