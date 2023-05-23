<?php

namespace Eastap\PhpBlog\Blog;

use Eastap\PhpBlog\UUID;

class Like
{
    public function __construct(
        private UUID $uuid,
        private UUID $postUuid,
        private UUID $userUuid
    )
    {
    }

    public function getUuid(): UUID {
        return $this->uuid;
    }

    public function getPostUuid(): UUID {
        return $this->postUuid;
    }

    public function getUserUuid(): UUID {
        return $this->userUuid;
    }
}
