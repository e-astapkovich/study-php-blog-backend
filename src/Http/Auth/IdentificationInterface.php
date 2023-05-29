<?php

namespace Eastap\PhpBlog\Http\Auth;

use Eastap\PhpBlog\Blog\User;
use Eastap\PhpBlog\Http\Request;

interface IdentificationInterface
{
    public function user(Request $request): User;
}
