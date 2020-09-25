<?php

declare(strict_types=1);

namespace app\Model;

use app\Admin\Model\Admin;
use app\Model\Concerns\Model;
use app\Model\Entity\Config as NConfig;
use app\Model\Entity\PageDescription;
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
     * @param $listId 配置组ID
     * @return array|int[]
     */
    public function setSystemConfigByList($configList, $listId)
    {
        Db::beginTransaction();
        foreach ($configList as $configName => $configValue) {
            $this->setSystemConfig($configName, $configValue, $listId);
        }
        Db::commit();
        return Admin::commonReturn(1);
    }

    /**
     * 单个设置系统配置
     * @param $configName
     * @param $configValue
     * @param $listId 配置组ID
     * @return array|int[]
     */
    public function setSystemConfig($configName, $configValue, $listId)
    {
        $valueStr = is_array($configValue) ? implode(',', $configValue) : $configValue;
        //如果有就更新。没有就添加
        $info = container('em')->getRepository('\app\Model\Entity\Config')->findBy(
            array('dbFieldName' => $configName)
        );
        if ($info) {
            //有 更新
            $clsConfig = $info[0];
            $action = 'edit';
        } else {
            $clsConfig = new NConfig();
            $action = 'add';
        }
        $clsConfig->setValue($valueStr);
        $clsConfig->setClId($listId);

        if ('add' == $action) {
            $clsConfig->setDbFieldName($configName);
            $clsConfig = Entity::setCommonData($clsConfig);
            container('em')->persist($clsConfig);
        } else {
            $clsConfig = Entity::setCommonData($clsConfig, 'updateTime');
        }
        container('em')->flush();

        return Admin::commonReturn(array('ack' => 1));
    }

    /**
     * @param $pageName
     * @return string
     */
    public function getPageDescription($pageName)
    {
        $clsPageDescription = container('em')->getRepository('\app\Model\Entity\PageDescription')->findBy(array('name' => $pageName));
        $pageDescription = '';
        if ($clsPageDescription) {
            $pageDescription = $clsPageDescription[0]->getDescription();
        }
        return $pageDescription;
    }

    /**
     * 配置单页面的提示信息
     * @param $pageName
     * @param $pageDescription
     * @return array|int[]
     * @throws \Exception
     */
    public function setPageDescription($pageName, $pageDescription)
    {
        if (!$pageName) {
            throw new \Exception('没有页面名');
        }
        if (!$pageDescription) {
            throw new \Exception('没有描述内容');
        }

        //如果有就更新。没有就添加
        $info = container('em')->getRepository('\app\Model\Entity\PageDescription')->findBy(
            array('name' => $pageName)
        );
        $action = '';
        if ($info) {
            //有 更新
            $clsPageDec = $info[0];
            $action = 'edit';
        } else {
            $clsPageDec = new PageDescription();
            $action = 'add';
        }
        $clsPageDec->setName($pageName);
        $clsPageDec->setDescription($pageDescription);

        if ('add' == $action) {
            $clsPageDec = Entity::setCommonData($clsPageDec);
            container('em')->persist($clsPageDec);
        }
        container('em')->flush();

        return Admin::commonReturn(array('ack' => 1));
    }
}
