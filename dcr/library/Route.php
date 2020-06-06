<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/4
 * Time: 0:56
 */

namespace dcr;

use DcrPHP\Config\Config;

class Route extends DcrBase
{
    private $configDirList = array();
    private $configList = array();

    /**
     * @var Rule类实例
     */
    private $rule;

    public function __construct()
    {
        $this->rule = container()->make('rule');
        $this->configDirList[] = ROOT_FRAME . DS . '..' . DS . 'config' . DS . 'route' . DS;

        $this->loadConfig();
    }

    public function loadConfig()
    {
        $clsConfig = new Config($this->configDirList[0]);
        foreach ($this->configDirList as $configDir) {
            $clsConfig->addDirectory($configDir);
        }
        $clsConfig->setDriver('php');
        $clsConfig->init();

        $configAll = $clsConfig->get();
        foreach ($configAll as $configDetail) {
            $this->configList = array_merge($this->configList, $configDetail);
        }
    }

    public function exec()
    {
    }

    public function addRuleFromRequest(Request $request)
    {
        $path = $request->getPath();
        if (empty($path) || '/' == $path) {
            $path = 'Index/Index/index';
        }

        //用route替换下先
        $path = $this->configList[$path] ? $this->configList[$path] : $path;

        $pathList = explode('/', $path);

        //添加规则给rule
        $ruleItem = container()->make('rule_item');

        $ruleItem->type = 'model';
        $ruleItem->model = $pathList[0];
        $ruleItem->controller = $pathList[1];
        $ruleItem->action = $pathList[2];
        unset($pathList[0], $pathList[1], $pathList[2]);
        $ruleItem->params = $pathList;

        //dd($_REQUEST);
        $request->setParams($pathList);

        $this->rule->addRuleItem($ruleItem);

        return $ruleItem;
    }
}
