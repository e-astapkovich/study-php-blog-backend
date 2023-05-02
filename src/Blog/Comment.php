<?php

namespace Eastap\PhpBlog\Blog;

class Comment {
  private int $id;
  private int $postId;
  private int $userId;
  private string $text;

  public function __construct($id, $postId, $userId, $text) {
    $this->id = $id;
    $this->postId = $postId;
    $this->userId = $userId;
    $this->text = $text;
  }

  public function __toString()
  {
    return $this->text;
  }

  public function getId() {
    return $this->id;
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
