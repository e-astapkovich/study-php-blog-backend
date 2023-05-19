<?php

namespace Eastap\PhpBlog\Http;

class ErrorResponse extends Response
{
    protected const SUCCESS = false;

    public function __construct(
        private string $reason = 'Something goes wrong'
    ) {
    }

    protected function payload() {
        return ['reason' => $this->reason];
    }
}
