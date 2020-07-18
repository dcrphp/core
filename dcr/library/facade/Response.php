<?php

declare(strict_types=1);

namespace dcr\facade;

class Response
{
    private $clsResponse;

    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        $this->clsResponse = new \Symfony\Component\HttpFoundation\Response($content, $status, $headers);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return call_user_func_array([$this->clsResponse, $name], $arguments);
    }
}
