<?php

namespace Eastap\PhpBlog\Interfaces;

use Eastap\PhpBlog\UUID;
use Eastap\PhpBlog\Blog\Like;

interface LikeRepositoryInterface
{
    public function save(Like $like): void;
    public function getByPostUuid(UUID $postUuid): array;
    public function isLikeExists(UUID $postUuid, UUID $userUuid): bool;
}
