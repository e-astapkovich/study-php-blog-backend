<?php

namespace Eastap\PhpBlog\Interfaces;
use Eastap\PhpBlog\UUID;

interface LikeRepositoryInterface
{
    public function save(): void;
    public function getByPostUuid(UUID $postUuid): array;
}
