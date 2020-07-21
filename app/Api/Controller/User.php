<?php

declare(strict_types=1);

namespace app\Api\Controller;

use app\Model\Api;

class User extends Api
{

    /**
     * @OA\Get(
     *     path="/api/user/get-user",
     *     tags={"用户中心"},
     *     summary="获取用户信息",
     *     description="传入名字后获取用户信息",
     *     @OA\Parameter(
     *          ref="#/components/parameters/token"
     *     ),
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
     *         ref="#/components/responses/response_seccess"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         ref="#/components/responses/response_error"
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
        $info = $clsUser->getInfo(get('username'), $option);
        return $clsApi->output($info, is_array($info), 1002, '没有找到会员信息');
    }
}
