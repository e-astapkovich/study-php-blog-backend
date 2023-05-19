<?php

namespace Eastap\PhpBlog\Http;


abstract class Response
{
    protected const SUCCESS = true;

    public function send() {
        $data = ['success' => static::SUCCESS] + $this->payload();
        header('Content-Type: application/json');
        header('Test-Header: Hello-from-header');
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    abstract protected function payload();
}
