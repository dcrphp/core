<?php

namespace app\Admin\Model;

use dcr\facade\Db;

class Tools
{
    public function getTableEditEditAddition($key)
    {
        return ROOT_APP . DS . 'Admin' . DS . 'Config' . DS . 'TableEdit' . DS . $key . DS . 'edit.php';
    }

    public function getTableEditDeleteAddition($key)
    {
        return ROOT_APP . DS . 'Admin' . DS . 'Config' . DS . 'TableEdit' . DS . $key . DS . 'delete.php';
    }

    /**
     * 1.0.5-3废弃 请用app/model/Tooles
     * 生成TableEdit时，默认显示的字段
     * @return string[]
     */
    public function getDefaultFieldConfigAbandon()
    {
        return array(
            'list' => array('id', 'add_time', 'name', 'title'),
            'search' => array('name', 'title'),
            'search_type' => 'like', //如果是搜索，则默认这个
        );
    }

    /**
     * 把html中的代码实别出来，替换成实际的变量 比如get.a换成get('a')
     * @param $html html代码
     * @return html代码|string|string[]
     */
    public function generateAdditionHtml($html)
    {
        if (preg_match_all('/\{((get)|(post))\.([\w\W]*)\}/U', $html, $result)) {
            foreach ($result[0] as $key => $item) {
                $functionName = $result[1][$key];
                $itemKey = $result[4][$key];
                $html = str_replace($item, $functionName($itemKey), $html);
            }
        }
        return $html;
    }

    /**
     * 通过ID获取TableEdit的key
     * @param $id
     */
    public function getTableEditKeyById($id)
    {
        $info = Db::select(
            array(
                'table' => 'config_table_edit_list',
                'where' => "id='{$id}'",
                'limit' => 1,
                'col' => 'keyword',
            )
        );
        if (empty($info)) {
            throw new \Exception('没有找到本配置');
        }
        $info = current($info);
        return $info['keyword'];
    }

    /**
     * since 1.0.5-3起作废 请用app->model->Tools相关的function
     * 通过关键字获取单表配置
     * @param $key
     * @return void
     */
    public function getTableEditConfigAbandon($key)
    {
    }

    /**
     * 1.0.5-3废弃 请用app/model/Tools
     * 通过表名生成单表管理
     * @param $pageModel
     * @param $keyword
     * @param $tableName
     * @param $pageTitle
     * @return array|int[]
     * @throws \Exception
     */
    public function tableEditGenerateAbandon($pageModel, $keyword, $tableName, $pageTitle)
    {
        $dbInfoMain = array();
        $dbInfoMain['page_title'] = $pageTitle;
        $dbInfoMain['keyword'] = $keyword;
        $dbInfoMain['table_name'] = $tableName;
        $dbInfoMain['page_model'] = $pageModel;
        $dbInfoMain['edit_window_width'] = '70%';
        $dbInfoMain['edit_window_height'] = '70%';
        $dbInfoMain['zt_id'] = 1;
        $dbInfoMain['add_user_id'] = intval(session('userId'));

        Db::beginTransaction();

        $id = Db::insert('config_table_edit_list', $dbInfoMain);
        //$id = 7;
        //开始子字段表
        $columns = Db::getConnection()->getSchemaManager()->listTableColumns($tableName);
        $defaultConfig = $this->getDefaultFieldConfig();
        foreach ($columns as $clsColumn) {
            $dbInfoSub = array();
            $fieldName = $clsColumn->getName();

            $dbInfoSub['is_show_list'] = in_array($fieldName, $defaultConfig['list']) ? 1 : 0;
            $dbInfoSub['is_search'] = in_array($fieldName, $defaultConfig['search']) ? 1 : 0;
            $dbInfoSub['search_type'] = in_array(
                $fieldName,
                $defaultConfig['search']
            ) ? $defaultConfig['search_type'] : '';
            $dbInfoSub['is_update_required'] = 0;
            $dbInfoSub['is_update'] = 0;
            $dbInfoSub['is_insert_required'] = 0;
            $dbInfoSub['is_insert'] = 0;
            //$fieldName['tip'] = $fieldInfo['Comment'];
            $dbInfoSub['data_type'] = substr($fieldName, 0, 3) == 'is_' ? 'checkbox' : 'text';
            $dbInfoSub['title'] = $clsColumn->getComment();
            $dbInfoSub['db_field_name'] = $fieldName;
            $dbInfoSub['ctel_id'] = $id;
            $dbInfoSub['zt_id'] = 1;

            Db::insert('config_table_edit_item', $dbInfoSub);
        }

        Db::commit();
        return Admin::commonReturn(1);
    }
}
