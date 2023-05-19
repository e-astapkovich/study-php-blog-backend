<?php

namespace Eastap\PhpBlog\Interfaces;

use Eastap\PhpBlog\Blog\Comment;
use Eastap\PhpBlog\UUID;

interface CommentRepositoryInterface
{
  public function save(Comment $comment): void;
  public function get(UUID $id): Comment;
}
