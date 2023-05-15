<?php

namespace Eastap\PhpBlog\Http\Actions;

use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\Response;

interface ActionInterface
{
    public function handle(Request $request): Response;
}
