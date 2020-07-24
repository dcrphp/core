<?php

namespace app\Admin\Model;

use dcr\facade\Db;

class Plugins
{
    private $pluginDir = ROOT_APP . DS . 'Admin' . DS . 'Plugins';

    public function getLocalPluginsList()
    {
        $listPlugins = array();
        $list = scandir($this->pluginDir);
        foreach ($list as $pluginName) {
            if (in_array($pluginName, array('.', '..'))) {
                continue;
            }
            $subDir = $this->pluginDir . DS . $pluginName;
            $configPath = $subDir . DS . 'Config.php';
            if (file_exists($configPath)) {
                $listPlugins[$pluginName] = include_once $configPath;
                $listPlugins[$pluginName]['source'] = 'local';
            }
        }

        return $listPlugins;
    }

    public function getInstalledList()
    {
        return DB::select(array(
                               'table' => 'plugins',
                               'where' => 'is_valid=1',
                           ));
    }

    public function getConfig($pluginName)
    {
        $subDir = $this->pluginDir . DS . $pluginName;
        $configPath = $subDir . DS . 'Config.php';
        if (!file_exists($configPath)) {
            throw new \Exception($pluginName . ':没有找到配置文件');
        }
        $config = include_once $configPath;

        return $config;
    }

    public function getControllerClass($pluginName)
    {

        return "\\app\\Admin\\Plugins\\{$pluginName}\\Controller\\{$pluginName}";
    }

    public function getPluginDir($pluginName)
    {
        return $this->pluginDir . DS . $pluginName;
    }
}
