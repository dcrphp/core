<?php

declare(strict_types=1);

namespace app\Model;

use dcr\DcrBase;

class Api extends DcrBase
{
    private $jsonPath = ROOT_PUBLIC . DS . 'storage' . DS . 'api.json';

    public function __construct()
    {
    }

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
        //验证token
        $clsConfig = new Config();
        $systemToken = $clsConfig->getSystemConfig('api_token');
        if (empty($systemToken)) {
            return json_encode(array('ack' => 0, 'error_id' => 1000, 'msg' => '请先在后台配置好api token'));
        }
        if ($systemToken != get('token')) {
            return json_encode(array('ack' => 0, 'error_id' => 1001, 'msg' => 'token错误'));
        }
        $result = array();
        $result['ack'] = $ack ? 1 : 0;
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
