<?php

namespace app\Model;

class Entity
{
    /**
     * 设置entity的通用数据 比如添加时间 修改时间
     * @param $clsEntity
     * @param string $field 要更新的字段
     * @param int $approval
     * @return mixed
     */
    public static function setCommonData($clsEntity, $field = 'isApproval,ztId,addTime,updateTime,addUserId', $approval = 1)
    {
        $fieldArr = explode(',', $field);

        $ztId = session('ztId');
        $addUserId = intval(session('userId'));
        $dataTimeNow = new \DateTime("now");
        foreach ($fieldArr as $fieldKey) {
            $functionName = 'set' . ucfirst($fieldKey);
            switch ($fieldKey) {
                case 'isApproval':
                    $clsEntity->$functionName($approval);
                    break;
                case 'ztId':
                    $clsEntity->$functionName($ztId);
                    break;
                case 'addTime':
                case 'updateTime':
                    $clsEntity->$functionName($dataTimeNow);
                    break;
                case 'addUserId':
                    $clsEntity->$functionName($addUserId);
                    break;
            }
        }
        return $clsEntity;
    }
}
