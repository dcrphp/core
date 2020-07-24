<?php

use app\Admin\Model\Common;
use app\Admin\Model\Config;
use app\Admin\Model\Plugins;

/**
 * 后台菜单配置
 * 本配置主格式可以menu-user为案例
 */
$menu = array(
    'user' => array(
        'icon' => '&#xe60d;', //图标
        'title' => '会员管理', //一级菜单
        'sub' => array(  //子菜单
            array(
                'url' => '/admin/user/list-view', //地址
                'title' => '会员列表', //标题
            ),
            array(
                'url' => '/admin/user/role-view',
                'title' => '角色列表',
            ),
            array(
                'url' => '/admin/user/permission-view',
                'title' => '权限列表',
            ),
        ),
    ),
    'tools' => array(
        'icon' => '&#xe61a;',
        'title' => '系统工具',
        'sub' => array(
            array(
                'url' => '/admin/tools/api-view',
                'title' => 'API',
            ),
            array(
                'url' => '/admin/tools/api-doc-general',
                'title' => ' - 文档',
            ),
            array(
                'url' => '/admin/tools/table-edit-list-view/api_permission',
                'title' => ' - DATA权限',
            ),
            array(
                'url' => '/admin/tools/plugins-installed-view',
                'title' => '插件中心',
            ),
        ),
    ),
    'config' => array(
        'icon' => '&#xe62e;',
        'title' => '系统配置',
        'sub' => array(
            array(
                'url' => '/admin/tools/table-edit-list-view/config_table_edit_list',
                'title' => '单表配置',
            ),
            array(
                'url' => '/admin/config/config-list-view/model',
                'title' => '模组配置',
            ),
            array(
                'url' => '/admin/config/config-list-view',
                'title' => '配置项配置',
            ),
        ),
    ),
    'table_edit' => array(
        'icon' => '&#xe627;',
        'title' => '单表中心',
        'sub' => array(
        ),
    ),
);

//得到插件列表
$clsPlugin = new Plugins();
$listPlugin = $clsPlugin->getInstalledList();
foreach ($listPlugin as $infoPlugin) {
    //dd($infoPlugin);
    $menu['tools']['sub'][] = array(
        'url' => '/admin/tools/plugins-index-view/' . $infoPlugin['name'],
        'title' => ' - ' . $infoPlugin['title'],
    );
}

//得到单表列表
$clsTools = new \app\Model\Tools();
$tableEditList = $clsTools->getTableEditList(array('order'=>'id desc', 'col'=>'page_title,keyword'));
foreach ($tableEditList as $tableEditInfo) {
    $menu['table_edit']['sub'][] = array(
        'url' => '/admin/tools/table-edit-list-view/' . $tableEditInfo['keyword'],
        'title' => $tableEditInfo['page_title'],
    );
}

$clsConfig = new Config();
$listConfig = $clsConfig->getConfigList(0, 'config');
foreach ($listConfig as $infoConfig) {
    //dd($infoPlugin);
    $menu['config']['sub'][] = array(
        'url' => '/admin/config/config-view/' . $infoConfig['id'],
        'title' => ' - ' . $infoConfig['name'],
    );
}

$clsConfig = new Config();
$modelList = $clsConfig->getConfigList(0, 'model');
foreach ($modelList as $modelInfo) {
    $menuKey = 'model-' . $modelInfo['keyword'];
    $menu[$menuKey] = array();
    $menu[$menuKey]['icon'] = '&#xe620;';
    $menu[$menuKey]['title'] = $modelInfo['name'];
    $menu[$menuKey]['sub'] = array();
    $menu[$menuKey]['sub'][] = array(
        'url' => '/admin/model/list-view/' . $modelInfo['keyword'],
        'title' => $modelInfo['name'] . '列表'
    );
    $menu[$menuKey]['sub'][] = array(
        'url' => '/admin/model/category-view/' . $modelInfo['keyword'],
        'title' => $modelInfo['name'] . '分类'
    );
}
/*dd($menu);
exit;*/
return $menu;
