<?php

namespace app\Admin\Controller;

use app\Admin\Model\Common;
use app\Admin\Model\Factory;
use app\Admin\Model\Plugins;
use app\Admin\Model\Tools as MTools;
use app\Model\Api;
use app\Model\Tools as NMTools;
use dcr\App;
use dcr\facade\Db;
use dcr\Page;
use dcr\Request;
use dcr\View;

class Tools
{

    private $modelName = '工具';

    /**
     * @permission /系统工具
     * @return mixed
     * @throws \Exception
     */
    public function pluginsView()
    {

        $assignData = array();
        $assignData['page_title'] = '插件中心';
        $assignData['page_model'] = $this->modelName;

        //得出本地插件列表
        $clsPlugins = new Plugins();
        $localPluginsList = $clsPlugins->getLocalPluginsList();
        $assignData['plugin_list'] = $localPluginsList;

        $listInstalled = $clsPlugins->getInstalledList();
        $listInstalled = array_column($listInstalled, 'name');
        $assignData['plugin_installed_list'] = $listInstalled;

        return Factory::renderPage('tools/plugins', $assignData);
    }

    public function pluginsInstalledView()
    {

        $assignData = array();
        $assignData['page_title'] = '已安装列表';
        $assignData['page_model'] = $this->modelName;

        $clsPlugins = new Plugins();
        $list = $clsPlugins->getInstalledList();
        $assignData['plugin_list'] = $list;

        return Factory::renderPage('tools/plugins-installed', $assignData);
    }

    public function pluginInstallAjax()
    {
        $name = post('name');
        $source = post('source');

        $clsPlugins = new \app\Model\Plugins();
        $clsPlugins->setName($name);
        $result = $clsPlugins->install();
        return Factory::renderJson($result);
    }

    /**
     * 插件的核心方法:通过不同的参数调用到插件的function
     * 具体请参看帮助中心的[插件开发]
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function pluginsAjax(Request $request)
    {
        $params = $request->getParams();
        $functionName = current($params) ? current($params) : post('function_name');
        $functionName = $functionName ? $functionName : get('function_name');
        $functionName = APP::formatParam($functionName);

        $pluginName = post('plugin_name') ? post('plugin_name') : get('plugin_name');

        $clsPlugins = new Plugins();
        $pluginControllerName = $clsPlugins->getControllerClass($pluginName);
        if (!class_exists($pluginControllerName)) {
            throw new \Exception($pluginControllerName . ':Controller不存在');
        }

        $pluginClass = new $pluginControllerName();
        if (!method_exists($pluginClass, $functionName)) {
            throw new \Exception($functionName . ':function不存在');
        }

        $result = $pluginClass->$functionName(array_merge(post(), get()));
        return Factory::renderJson($result);
    }

    /**
     * 插件核心入口，进入插件的首页，就是调用这个
     * @param Request $request
     * @param View $view
     * @return mixed
     * @throws \Exception
     */
    public function pluginsIndexView(Request $request, View $view)
    {
        $params = $request->getParams();
        $pluginName = current($params) ? current($params) : 'TableGeneral'; //默认一个是为了自动化测试

        $clsPlugins = new Plugins();
        $pluginDir = $clsPlugins->getPluginDir($pluginName);
        $config = $clsPlugins->getConfig($pluginName);
        $viewDir = $pluginDir . DS . 'View';
        $indexView = 'index';
        if (!file_exists($viewDir . DS . $indexView . '.html')) {
            throw new \Exception('没有找到这个view:' . $indexView);
        }
        $assignData = array();
        $assignData['page_title'] = $config['description'];
        $assignData['page_model'] = $this->modelName;
        //调用插件的index
        $pluginControllerName = $clsPlugins->getControllerClass($pluginName);
        if (class_exists($pluginControllerName)) {
            $pluginClass = new $pluginControllerName();
            if (method_exists($pluginClass, 'index')) {
                $pluginClass->index($view);
            }
        }
        //$pluginIndexController = new ;
        return Factory::renderPage($indexView, $assignData, $viewDir);
    }

    public function apiView()
    {
        echo "更多文档请看API目录下的README或https://github.com/dcrphp/core/wiki/%E8%AF%B4%E6%98%8E:API";
        exit;
    }

    public function apiDocGeneral()
    {
        $clsApi  = new Api();
        $clsApi->initDoc();
        echo "API文档已经于[" . date('Y-m-d H:i:s') . "]刷新，请点击<a target='_blank' href='/api/dist/'>查看</a>";
        exit;
    }

    /**
     * 调用方式
     */
    public function tableEditInfoView()
    {
        $params = container('request')->getParams();
        $keyId = current($params);
        $info = Db::select(
            array(
                'table' => 'config_table_edit_list',
                'where' => array("id={$keyId}"),
                'col' => 'keyword',
                'limit' => 1,
            )
        );
        if (!$info) {
            throw new \Exception('没有找到信息');
        }
        $info = current($info);

        $assignData['page_title'] = '查看调用方式';
        $assignData['page_model'] = '系统配置';
        $assignData['key'] = $info['keyword'];

        return Factory::renderPage('tools/show', $assignData);
    }

    public function tableEditEditAjax()
    {
        $data = post();
        $key = $data['key'];
        //用通用接口去处理
        $clsTools = new MTools();
        $clsNMTools = new NMTools();
        $config = $clsNMTools->getTableEditConfig($key);

        if ('delete' == $data['type']) {
            //调用编辑里额外的php检测数据
            $phpAdditionPath = $clsTools->getTableEditDeleteAddition($key);

            if (file_exists($phpAdditionPath)) {
                require_once $phpAdditionPath;
            }

            $result = Common::CUDDbInfo(
                $config['table_name'],
                $config['table_pre'],
                array(),
                $data['type'],
                $option = array('id' => $data['id'], 'check' => array())
            );
        } else {
            //dd($config);
            //处理检测程序
            $check = array();

            //得出要更新的列名
            $listCol = array();
            if ('add' == $data['type']) {
                foreach ($config['col'] as $configKey => $configValue) {
                    if ($configValue['is_insert_required']) {
                        $check[$configKey] = array('type' => 'required');
                    }
                    if ($configValue['is_insert']) {
                        $listCol[] = $configValue;
                    }
                }
            }
            if ('edit' == $data['type']) {
                foreach ($config['col'] as $configKey => $configValue) {
                    if ($configValue['is_update_required']) {
                        $check[$configKey] = array('type' => 'required');
                    }
                    if ($configValue['is_update']) {
                        $listCol[] = $configValue;
                    }
                }
            }

            //要更新或添加的数据
            $dbInfo = array();
            foreach ($listCol as $colInfo) {
                $value = $data[$colInfo['db_field_name']];
                $value = is_array($value) ? implode(',', $value) : $value;
                if (is_null($value)) {
                    $value = '';
                }
                if (substr($colInfo['db_field_name'], 0, 3) == 'is_') {
                    $value = ('是' == $value ? 1 : 0);
                }
                $dbInfo[$colInfo['db_field_name']] = $value;
            }
            //dd($dbInfo);
            //dd($data);
            //dd($listCol);
            //调用编辑里额外的php程序
            $phpAdditionPath = $clsTools->getTableEditEditAddition($key);

            if (file_exists($phpAdditionPath)) {
                require_once $phpAdditionPath;
            }

            $result = Common::CUDDbInfo(
                $config['table_name'],
                $config['table_pre'],
                $dbInfo,
                $data['type'],
                $option = array('id' => $data['id'], 'check' => $check)
            );
        }

        return Factory::renderJson($result);
    }

    public function tableEditEditView(Request $request)
    {

        $assignData = array();
        $params = $request->getParams();
        $type = $params[0];
        $key = $params[1];
        $id = $params[2];
        $clsTools = new MTools();
        $clsNMTools = new NMTools();
        $config = $clsNMTools->getTableEditConfig($key);

        $listCol = array();
        $checkKey = 'add' == $type ? 'is_insert' : 'is_update';

        //得出insert或update的字段来
        foreach ($config['col'] as $configKey => $configValue) {
            if ($configValue[$checkKey]) {
                $listCol[$configKey] = $configValue;
            }
        }
        //开始格式化成标准格式
        //如果是编辑 则得出值
        $info = array();
        if ('edit' == $type) {
            $info = Db::select(
                array(
                    'table' => $config['table_name'],
                    'where' => "id={$id}",
                    'limit' => 1,
                )
            );
            $info = current($info);
            $assignData['edit_page_addition_html'] = $clsTools->generateAdditionHtml($config['edit_page_addition_html']);
        } else {
            $assignData['add_page_addition_html'] = $clsTools->generateAdditionHtml($config['add_page_addition_html']);
        }
        //dd($info);
        $fieldList = Common::generalHtmlForItem($listCol, $info);
        //dd($fieldList);

        $assignData['page_title'] = $config['page_title'];
        $assignData['page_model'] = $config['page_model'];
        $assignData['type'] = $type;
        $assignData['key'] = $key;
        $assignData['field_list'] = $fieldList;
        $assignData['id'] = $id;
        $assignData['index_id'] = $config['index_id'];
        //dd($assignData);

        return Factory::renderPage('tools/table-edit-edit', $assignData);
    }

    public function tableEditListView(Request $request)
    {

        $params = $request->getParams();
        $key = current($params);
        $clsTools = new MTools();
        //$configPath = $clsTools->getTableEditConfigPath($key);
        //$config = include_once $configPath;
        $clsNMTools = new NMTools();
        $config = $clsNMTools->getTableEditConfig($key);
        //dd($config);
        $assignData = array();
        $assignData['page_title'] = $config['page_title'];
        $assignData['page_model'] = $config['page_model'];
        $allowConfigFromRequest = $config['allow_config_from_request']; //传过来允许使用的变量
        $allowConfigFromRequestArr = array();
        if ($allowConfigFromRequest) {
            $allowConfigFromRequestArr = explode(',', $allowConfigFromRequest);
        }

        $searchData = get();
        //分页去除
        unset($searchData['page']);

        $whereArr = array();
        if ($config['list_where']) {
            $whereArr[] = $config['list_where'];
        }
        if (in_array('list_where', $allowConfigFromRequestArr) && $searchData['list_where']) {
            $whereArr[] = $searchData['list_where'];
        }

        //dd($searchData);
        //改这里要注意:表的搜索用的这里，还有额外的list_where要解析
        foreach ($searchData as $searchKey => $searchValue) {
            if (!$searchValue) {
                continue;
            }
            $searchType = $config['col'][$searchKey]['search_type'];
            switch ($searchType) {
                case 'like':
                    $whereArr[] = "`{$searchKey}` like '%{$searchValue}%'";
                    break;
                case 'like_left':
                    $whereArr[] = "`{$searchKey}` like '{$searchValue}%'";
                    break;
                case 'like_right':
                    $whereArr[] = "`{$searchKey}` like '%{$searchValue}'";
                    break;
                default:
                    //等于或其它的，都用=来判断
                    if ('list_where' != $searchKey) {
                        $whereArr[] = "`{$searchKey}`='{$searchValue}'";
                    }
                    break;
            }
        }

        //获取列表要显示的列
        $listCol = array();

        $searchCol = array();
        foreach ($config['col'] as $configKey => $configValue) {
            if ($configValue['is_show_list']) {
                $listCol[$configKey] = $configValue;
            }
            if ($configValue['is_search']) {
                $searchCol[$configKey] = $configValue;
            }
        }

        //dd($searchCol);
        if ($searchCol) {
            $searchCol = Common::generalHtmlForItem($searchCol, $searchData);
        }
        //exit;
        //dd($searchCol);
        //dd($searchData);
        //dd($listCol);
        //dd($config);

        //总数量
        $pageInfo = Db::select(
            array(
                'table' => $config['table_name'],
                'where' => $whereArr,
                'col' => array('count(id) as num'),
            )
        );

        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 30;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $cols = array_keys($listCol);
        if (!in_array('id', $cols)) {
            $cols[] = 'id';
        }

        $list = Db::select(
            array(
                'table' => $config['table_name'],
                'order' => $config['list_order'] ? $config['list_order'] : 'id desc',
                'where' => $whereArr,
                'col' => '`' . implode('`,`', $cols) . '`',
                'offset' => ($page - 1) * $pageNum,
                'limit' => $pageNum,
            )
        );

        //dd($config);

        //进行一些初始化
        foreach ($list as $listKey => $listInfo) {
            if ($config['addition_option_html']) {
                $list[$listKey]['addition_option_html'] = str_replace(
                    '{db.index_id}',
                    $list[$listKey]['id'],
                    $config['addition_option_html']
                );
            }
        }

        $assignData['list'] = $list;
        $assignData['list_col'] = $listCol;
        $assignData['search_col'] = $searchCol;
        $assignData['page'] = $page;
        $assignData['user_num'] = $pageTotalNum;
        $assignData['pages'] = $pageHtml;
        $assignData['config'] = $config;
        $assignData['key'] = $key;
        $assignData['add_button_addition_html'] = $clsTools->generateAdditionHtml($config['add_button_addition_html']);
        $assignData['edit_button_addition_html'] = $clsTools->generateAdditionHtml(
            $config['edit_button_addition_html']
        );
        $assignData['button_area_addition_html'] = $clsTools->generateAdditionHtml(
            $config['button_area_addition_html']
        );
        #print_r($list);
        #dump($config);

        return Factory::renderPage('tools/table-edit-list', $assignData);
    }

    public function tableEditGenerateView()
    {
        $assignData = array();
        $assignData['page_title'] = '自动生成';
        $assignData['page_model'] = '系统配置';

        return Factory::renderPage('tools/table-edit-generate', $assignData);
    }

    public function tableEditGenerateAjax()
    {
        $keyword = post('keyword');
        $tableName = post('table_name');
        $pageTitle = post('page_title');
        $pageModel = post('page_model');

        $clsTools = new \app\Model\Tools();
        $result = $clsTools->tableEditGenerate($pageModel, $keyword, $tableName, $pageTitle);

        return Factory::renderJson($result);
    }

    public function tableEditUpdateFieldAjax()
    {
        $tableName = post('table_name');
        $id = post('id');
        $value = post('value');
        $field = post('field');

        $clsTools = new \app\Model\Tools();
        $result = $clsTools->tableEditUpdateField($tableName, $id, $value, $field);

        return Factory::renderJson($result);
    }
}
