<?php

declare(strict_types=1);

namespace app\Api\Controller;

use app\Model\Api;

class Config
{

    /**
     * @OA\Get(
     *     path="/api/config/get-config",
     *     tags={"配置中心"},
     *     summary="获取配置信息",
     *     description="传入配置名后获取配置信息",
     *     @OA\Parameter(
     *         name="config_name",
     *         in="query",
     *         description="配置名",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function getConfig()
    {
        $clsApi = new Api();
        $clsConfig = new \app\Model\Config();
        $configValue = $clsConfig->getSystemConfig(get('config_name'));

        return $clsApi->output($configValue, strlen($configValue) > 0 ? 1 : 0, 1000, '获取失败');
    }
}
