<?php

namespace Eastap\PhpBlog\Interfaces;

use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\UUID;

interface UserRepositoryInterface
{
  public function save(User $user): void;
  public function get(UUID $uuid): User;
  public function getByLogin(string $login): User;
}
