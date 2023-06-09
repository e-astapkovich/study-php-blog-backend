<?php

namespace Eastap\PhpBlog\Http;

use Eastap\PhpBlog\Exceptions\HttpException;
use JsonException;

class Request
{
    public function __construct(
        private array $get,
        private array $server,
        private string $body
    ) {
    }

    public function method(): string
    {
        if (!array_key_exists('REQUEST_METHOD', $this->server)) {
            throw new HttpException("Cannot get method from the request");
        }
        return $this->server['REQUEST_METHOD'];
    }

    public function path(): string
    {

        if (!array_key_exists('REQUEST_URI', $this->server)) {
            throw new HttpException('Cannot get path from the request');
        }
        $components = parse_url($this->server['REQUEST_URI']);

        if (!is_array($components) || !array_key_exists('path', $components)) {
            throw new HttpException('Cannot get path from the request');
        }

        return $components['path'];
    }

    public function param(string $param): string
    {
        if (!array_key_exists($param, $this->get)) {
            throw new HttpException("No such query param in the request: $param");
        }

        $value = trim($this->get["$param"]);

        if (empty($value)) {
            throw new HttpException("Empty param in the request: $param");
        }

        return $value;
    }

    public function header(string $header): string
    {
        $headerName = 'HTTP_' . mb_strtoupper(str_replace('-', '_', $header));

        if (!array_key_exists($headerName, $this->server)) {
            throw new HttpException("No such header in the request: $header");
        }

        $value = trim($this->server[$headerName]);

        if (empty($value)) {
            throw new HttpException("Empty header in the request: $header");
        }

        return $value;
    }

    public function JsonBody(): array
    {
        try {
            $data = json_decode(
                $this->body,
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new HttpException('Cannot decode JSON');
        }

        if (!is_array($data)) {
            throw new HttpException("Not an array/object in json body");
        }

        return $data;
    }

    public function JsonBodyField(string $field)
    {
        $data = $this->JsonBody();

        if (!array_key_exists($field, $data)) {
            throw new HttpException("No such field: $field");
        }

        if (empty($data[$field])) {
            throw new HttpException("Empty field: $field");
        }

        return $data[$field];
    }
}
