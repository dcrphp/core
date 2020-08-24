<?php

declare(strict_types=1);

namespace app\Model\TraitClass;

use app\Admin\Model\Admin;
use app\Model\Entity;
use dcr\facade\Db;

trait ToolsTableEdit
{

    /**
     * 获取全部的表列表
     * @param array $option
     * @return mixed
     */
    public function getTableEditList($option = array())
    {
        $option['table'] = 'config_table_edit_list';
        return Db::select($option);
    }

    /**
     * 通过关键字 获取表的配置
     * @param $key
     * @return array
     * @throws \Exception
     */
    public function getTableEditConfig($key)
    {
        if (empty($key)) {
            throw new \Exception('请输入配置表的关键字');
        }
        $info = Db::select(
            array(
                'table' => 'config_table_edit_list',
                'where' => "keyword='{$key}'",
                'limit' => 1,
            )
        );
        if (empty($info)) {
            throw new \Exception('没有找到本配置');
        }
        $info = current($info);
        $config = array();
        $keys = array_keys($info);
        foreach ($keys as $key) {
            $keyNew = str_replace('', '', $key);
            $config[$keyNew] = $info[$key];
        }
        //得出字段配置

        $fieldList = Db::select(
            array(
                'table' => 'config_table_edit_item',
                'where' => "ctel_id={$info['id']}",
            )
        );
        $fieldKeys = array_column($fieldList, 'db_field_name');
        $fieldList = array_combine($fieldKeys, $fieldList);

        $config['col'] = $fieldList;

        return $config;
    }

    /**
     * 生成TableEdit时，默认显示的字段
     * @return string[]
     */
    public function getDefaultFieldConfig()
    {
        return array(
            'list' => array('id', 'add_time', 'name', 'title'),
            'search' => array('name', 'title'),
            'search_type' => 'like', //如果是搜索，则默认这个
        );
    }

    /**
     * 通过表名生成单表管理
     * @param $pageModel
     * @param $keyword
     * @param $tableName
     * @param $pageTitle
     * @return array|int[]
     * @throws \Exception
     */
    public function tableEditGenerate($pageModel, $keyword, $tableName, $pageTitle)
    {
        //检测数据
        if (empty($pageModel)) {
            throw new \Exception('模型配置不能为空');
        }
        if (empty($keyword)) {
            throw new \Exception('关键字不能为空');
        }
        if (empty($tableName)) {
            throw new \Exception('表名不能为空');
        }
        if (empty($pageTitle)) {
            throw new \Exception('页面标题不能为空');
        }
        $clsConfigTEL = new \app\Model\Entity\ConfigTableEditList();
        $clsConfigTEL->setPageTitle($pageTitle);
        $clsConfigTEL->setKeyword($keyword);
        $clsConfigTEL->setTableName($tableName);
        $clsConfigTEL->setPageModel($pageModel);
        $clsConfigTEL->setEditWindowWidth('70%');
        $clsConfigTEL->setEditWindowHeight('70%');
        $clsConfigTEL = Entity::setCommonData($clsConfigTEL);

        Db::beginTransaction();

        container('em')->persist($clsConfigTEL);
        container('em')->flush();
        $id = $clsConfigTEL->getId();

        $columns = Db::getConnection()->getSchemaManager()->listTableColumns($tableName);
        $defaultConfig = $this->getDefaultFieldConfig();
        foreach ($columns as $clsColumn) {
            $dbInfoSub = array();
            $fieldName = $clsColumn->getName();
            $clsConfigTEI = new Entity\ConfigTableEditItem();
            $clsConfigTEI->setIsShowList(in_array($fieldName, $defaultConfig['list']) ? 1 : 0);
            $clsConfigTEI->setIsSearch(in_array($fieldName, $defaultConfig['search']) ? 1 : 0);
            $clsConfigTEI->setSearchType(
                in_array($fieldName, $defaultConfig['search']) ? $defaultConfig['search_type'] : ''
            );
            $clsConfigTEI->setIsUpdateRequired(0);
            $clsConfigTEI->setIsUpdate(0);
            $clsConfigTEI->setIsInsertRequired(0);
            $clsConfigTEI->setIsInsert(0);
            $clsConfigTEI->setDataType(substr($fieldName, 0, 3) == 'is_' ? 'checkbox' : 'text');
            $clsConfigTEI->setTitle($clsColumn->getComment() ? $clsColumn->getComment() : '');
            $clsConfigTEI->setDbFieldName($fieldName);
            $clsConfigTEI->setCtelId($id);
            $clsConfigTEI = Entity::setCommonData($clsConfigTEI);

            container('em')->persist($clsConfigTEI);
            container('em')->flush();
        }

        Db::commit();
        return Admin::commonReturn(1);
    }

    /**
     * @param $tableName
     * @param $id
     * @param $value
     * @param $field
     * @return array|int[]
     * @throws \Exception
     */
    public function tableEditUpdateField($tableName, $id, $value, $field)
    {
        if (empty($tableName)) {
            throw new \Exception('表名不能为空');
        }
        if (empty($id)) {
            throw new \Exception('ID不能为空');
        }
        if (!isset($value)) {
            throw new \Exception('新值不能为空');
        }
        if (empty($field)) {
            throw new \Exception('字段不能为空');
        }

        //开始改
        $result = DB::update($tableName, array($field => $value), "id={$id}");
        return Admin::commonReturn(1);
    }
}
