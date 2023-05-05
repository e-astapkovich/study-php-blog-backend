<?php

namespace Eastap\PhpBlog\Interfaces;

use Eastap\PhpBlog\Blog\Post;
use Eastap\PhpBlog\UUID;

interface PostRepositoryInterface
{
  public function save(Post $post): void;
  public function get(UUID $id): Post;
}
