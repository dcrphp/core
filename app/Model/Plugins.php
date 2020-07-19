<?php

declare(strict_types=1);

namespace app\Model;

use app\Admin\Model\Admin;
use app\Model\Concerns\Model;
use app\Model\Entity\Plugins as NPlugins;

/**
 * Class User
 * @package app\Model
 */
class Plugins extends NPlugins implements Model
{
    /**
     * 插件目录
     * @var string
     */
    private $pluginDir = ROOT_APP . DS . 'Admin' . DS . 'Plugins';

    /**
     * 验证数据
     * @PrePersist @PreUpdate
     * @param $entity
     * @throws \Exception
     */
    public function validate($entity)
    {
    }

    public function install()
    {
        $pluginName = $this->getName();
        //判断存在不存在
        $dir = $this->pluginDir . DS . $pluginName;
        $configPath = $dir . DS . 'Config.php';

        if (!file_exists($configPath)) {
            throw new \Exception('插件不存在');
        }

        //取信息
        $pluginInfo = include_once $configPath;

        $entityList = container('em')->getRepository('\app\Model\Entity\Plugins')->findBy(array('name' => $pluginName));

        if ($entityList) {
            return Admin::commonReturn(0, '已经安装过了');
        }
        $clsPlugins = new NPlugins();
        $clsPlugins->setName($pluginName);
        $clsPlugins->setDescription($pluginInfo['description']);
        $clsPlugins->setAuthor($pluginInfo['author']);
        $clsPlugins->setVersion($pluginInfo['version']);
        $clsPlugins->setTitle($pluginInfo['title']);
        $clsPlugins = Entity::setCommonData($clsPlugins);

        container('em')->persist($clsPlugins);
        container('em')->flush();

        $pluginId = $clsPlugins->getId();

        return Admin::commonReturn($pluginId);
    }
}
