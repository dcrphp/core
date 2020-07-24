<?php

declare(strict_types=1);

namespace app\Api\Controller;

use app\Model\Api;
use app\Model\Entity;
use app\Model\Entity\ApiPermission;
use dcr\facade\Db;

class Data extends Api
{

    /**
     * @OA\Get(
     *     path="/api/data/get-data",
     *     tags={"数据中心"},
     *     summary="获取任意表的数据",
     *     description="本API需要你去[系统工具-API-API权限配置]允许的表和字段",
     *     @OA\Parameter(
     *          ref="#/components/parameters/token"
     *     ),
     *     @OA\Parameter(
     *         name="table",
     *         in="query",
     *         description="表名",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="where",
     *         in="query",
     *         description="查询的条件",
     *         required=false,
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
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="数据排序",
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
    public function getData()
    {
        //判断权限

        $table = get('table');
        $where = get('where');
        $field = get('field');
        $order = get('order');
        //判断有没有权限获取这个表
        if (!$this->hasDataPermission($table, $field)) {
            return Api::_output(null, is_array(null), 1002, '没有这个表或字段的权限，请联系管理员在[系统工具/API/Data权限]中添加');
        }
        $list = DB::select(
            array(
                'table' => $table,
                'where' => $where,
                'col' => $field,
                'order' => $order,
            )
        );
        return Api::_output($list, is_array($list), 1002, '没有找到信息');
    }

    /**
     * 判断本API有没有对某表和某字段的权限
     * @param $tableName
     * @param $fieldName
     */
    public function hasDataPermission($tableName, $fieldName)
    {
        $entityInfo = Entity::getByWhere('\app\Model\Entity\ApiPermission', array('tableName' => $tableName));
        if ('edit' == $entityInfo['type']) {
            //判断字段
            $configField = $entityInfo['entity']->getFieldName();
            if ('*' == $configField) {
                //配置为* 说明可以全部返回
                return true;
            } else {
                //判断是不是返回的字段有没有在允许字段列表
                $configFieldList = explode(',', $configField);
                $fieldNameList = explode(',', $fieldName);
                return !array_diff($fieldNameList, $configFieldList);
            }
        } else {
            return false;
        }
    }
}
