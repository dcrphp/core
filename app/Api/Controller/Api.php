<?php

/**
 * @OA\Info(
 *     description="本文档基于dcrphp core API类生成，编码好app\Api下的类，然后后台点击[系统工具/api刷新]，更新本文档",
 *     version="1.0.0",
 *     title="dcrphp core api中心",
 *     termsOfService="http://www.dcrcms.com/",
 *     @OA\Contact(
 *          email="junqing124@126.com"
 *     ),
 *     @OA\SecurityScheme(
 *          securityScheme="api_token",
 *          type="apiKey",
 *          in="body",
 *          description="认证token  Bearer+空格+token",
 *          name="Authorization"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Parameter(
 *     name="token",
 *     description="全局API配置",
 *     required=true,
 *     in="query",
 *     @OA\Schema(
 *          type="string",
 *     )
 * )
 * @OA\Response(
 *     response="response_error",
 *     description="Invalid status value",
 *     @OA\JsonContent(
 *          type="string"
 *     )
 * )
 * @OA\Response(
 *     response="response_seccess",
 *     description="Seccess",
 *     @OA\JsonContent(
 *          type="string"
 *     )
 * )
 */
