<?php

declare(strict_types=1);

namespace app\Api\Controller;

use app\Model\Api;

/**
 * @OA\Info(
 *     description="本文档基于dcrphp core API类生成，编码好app\Api下的类，然后后台点击[系统工具/api刷新]，更新本文档",
 *     version="1.0.0",
 *     title="dcrphp core api中心",
 *     termsOfService="http://www.dcrcms.com/",
 *     @OA\Contact(
 *         email="junqing124@126.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
class User
{

    /**
     * @OA\Get(
     *     path="/api/user/get-user",
     *     tags={"用户中心"},
     *     summary="获取用户信息",
     *     description="传入名字后获取用户信息",
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="用户名",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="field",
     *         in="query",
     *         description="需求的字段,默认返回全部",
     *         required=false,
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
    public function getUser()
    {
        $clsApi = new Api();
        $clsUser = new \app\Model\User();
        $option = array();
        if (get('field')) {
            $option['col'] = get('field');
        }
        $info = $clsUser->getInf1o(get('username'), $option);
        return $clsApi->output($info, is_array($info), 1000, '没有找到会员信息');
    }
}
