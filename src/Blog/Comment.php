<?php

namespace Eastap\PhpBlog\Blog;

use Eastap\PhpBlog\UUID;

class Comment {
  private UUID $uuid;
  private UUID $postId;
  private User $user;
  private string $text;

  public function __construct($uuid, $postId, $user, $text) {
    $this->uuid = $uuid;
    $this->postId = $postId;
    $this->user = $user;
    $this->text = $text;
  }

  public function __toString()
  {
    return $this->text;
  }

  public function getId() {
    return $this->uuid;
  }

  public function getPostId() {
    return $this->postId;
  }

  public function getUser() {
    return $this->user;
  }

  public function getText() {
    return $this->text;
  }
}
