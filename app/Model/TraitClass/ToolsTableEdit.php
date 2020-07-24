<?php

declare(strict_types=1);

namespace app\Model\TraitClass;

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
}
