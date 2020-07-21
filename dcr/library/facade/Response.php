<?php

declare(strict_types=1);

namespace dcr\facade;

use dcr\DcrBase;

class Response extends DcrBase
{
    private $clsResponse;

    /**
     * Response constructor.
     * @param mixed $content 输出内容 不一定是字符串，比如验证码图片也是在这输出
     * @param int $status
     * @param array $headers
     */
    public function __construct($content = '', int $status = 200, array $headers = [])
    {
        $this->clsResponse = new \Symfony\Component\HttpFoundation\Response($content, $status, $headers);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return call_user_func_array([$this->clsResponse, $name], $arguments);
    }

    public function redirect($url)
    {
        $response = new \Symfony\Component\HttpFoundation\RedirectResponse($url);
        $response->send();
    }
}
