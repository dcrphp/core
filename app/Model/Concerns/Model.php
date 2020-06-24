<?php
namespace app\Model\Concerns;

interface Model
{
    /**
     * entity的验证
     * @param $entity entity实例
     * @return mixed
     */
    public function validate($entity);
}