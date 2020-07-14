<?php

declare(strict_types=1);


namespace app\Model;

use app\Admin\Model\Admin;
use app\Model\Concerns\Model;
use app\Model\Entity\Config as NConfig;
use dcr\facade\Db;

class Config extends NConfig implements Model
{

    public function validate($entity)
    {
        // TODO: Implement validate() method.
    }

    /**
     * 获取系统配置
     * @param $configName
     * @return string
     */
    public function getSystemConfig($configName)
    {
        $info = container('em')->getRepository('\app\Model\Entity\Config')->findBy(
            array('dbFieldName' => $configName)
        );
        if ($info[0]) {
            $clsConfig = $info[0];
            return $clsConfig->getValue();
        } else {
            return '';
        }
    }

    /**
     * 批量设置系统配置
     * @param $configList
     * @return array|int[]
     */
    public function setSystemConfigByList($configList)
    {
        Db::beginTransaction();
        foreach ($configList as $configName => $configValue) {
            $this->setSystemConfig($configName, $configValue);
        }
        Db::commit();
        return Admin::commonReturn(1);
    }

    /**
     * 单个设置系统配置
     * @param $configName
     * @param $configValue
     * @return array|int[]
     */
    public function setSystemConfig($configName, $configValue)
    {
        $valueStr = is_array($configValue) ? implode(',', $configValue) : $configValue;
        //如果有就更新。没有就添加
        $action = 'add';
        $info = container('em')->getRepository('\app\Model\Entity\Config')->findBy(
            array('dbFieldName' => $configName)
        );
        if ($info) {
            //有 更新
            $clsConfig = $info[0];
            $action = 'edit';
        } else {
            $clsConfig = new NConfig();
        }
        $clsConfig->setValue($valueStr);

        if ('add' == $action) {
            $clsConfig = Entity::setCommonData($clsConfig);
            container('em')->persist($clsConfig);
        } else {
            $clsConfig = Entity::setCommonData($clsConfig, 'updateTime');
        }
        container('em')->flush();

        return Admin::commonReturn(array('ack' => 1));
    }
}
