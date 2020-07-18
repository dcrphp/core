<?php

declare(strict_types=1);

namespace app\Model;

use app\Admin\Model\Admin;
use app\Model\Concerns\Model;
use app\Model\Entity\ModelList;
use dcr\facade\Db;

/**
 * 模组 比如产品列表 新闻列表 公司资料等
 * Class Module
 * @package app\Model
 */
class Module extends ModelList implements Model
{

    public function validate($entity)
    {
        // TODO: Implement validate() method.
    }

    public function delete($moduleId)
    {
        //验证
        $info = DB::select(array('table' => 'model_list', 'col' => 'id', 'where' => "id={$moduleId}", 'limit' => 1));
        $info = current($info);

        if (!$info) {
            throw new \Exception('没有找到这个模组信息');
        }
        //逻辑
        DB::beginTransaction();
        $resultML = DB::delete('model_list', "id={$moduleId}");
        $resultMA = DB::delete('model_addition', "ma_ml_id={$moduleId}");
        $resultME = DB::delete('model_field', "mf_ml_id={$moduleId}");
        $result = $resultML & $resultMA & $resultME;
        if ($result) {
            DB::commit();
        } else {
            DB::rollback();
        }

        return Admin::commonReturn($result);
    }
}
