<?php

declare(strict_types=1);

namespace app\Model;

class Api
{
    private $jsonPath = ROOT_PUBLIC . DS . 'storage' . DS . 'api.json';

    /**
     * api输出
     * @param $data
     * @param int $ack
     * @param int $errorId
     * @param string $msg
     * @return false|string
     */
    public function output($data, $ack = 1, $errorId = 0, $msg = '')
    {
        $result = array();
        $result['ack'] = $ack;
        if ($ack) {
            $result['data'] = $data;
        } else {
            $result['error_id'] = $errorId;
            $result['msg'] = $msg;
        }
        return json_encode($result);
    }

    /**
     * 初始化api文档
     */
    public function initDoc()
    {
        $clsOpenApi = \OpenApi\scan(ROOT_APP . DS . 'Api' . DS . 'Controller');
        $apiDoc = $clsOpenApi->toYaml();
        file_put_contents($this->jsonPath, $apiDoc);
        /*echo $apiDoc;*/
    }
}
