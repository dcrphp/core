<?php

declare(strict_types=1);

namespace app\Api\Controller;

use app\Model\Api;

class User
{
    /**
     * @OA\Info(title="My First API", version="0.1")
     */

    /**
     * @OA\Get(
     *     path="/api/resource.json",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function getUser()
    {
        $clsApi = new Api();
        return $clsApi->output(array('a'));
    }
}