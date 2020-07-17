<?php

declare(strict_types=1);


namespace app\Model;

class Api
{
    private $jsonPath = ROOT_PUBLIC . DS . 'storage' . DS . 'api.json';

    public function output($data)
    {
        return json_encode($data);
    }

    /**
     * 初始化api文档
     */
    public function initDoc()
    {
        $openapi = \OpenApi\scan(ROOT_APP . DS . 'Api' . DS . 'Controller');
        $apiDoc = $openapi->toYaml();
        file_put_contents($this->jsonPath, $apiDoc);
        /*echo $apiDoc;*/
    }
}
