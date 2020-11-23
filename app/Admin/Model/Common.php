<?php

namespace app\Admin\Model;

use dcr\facade\Db;
use DcrPHP\Form\Form;

class Common
{

    /**
     * 返回数据库保留字段
     * @return string[]
     */
    public static function getDbBaseField()
    {
        $list = array(
            'add_time',
            'update_time',
            'approval_status',
            'add_user_id',
            'zt_id',
        );
        return $list;
    }

    public static function getFieldTypeList()
    {
        return array(
            array('name' => '单行文本', 'key' => 'text'),
            array('name' => '多行文本', 'key' => 'textarea'),
            array('name' => '单选框', 'key' => 'radio'),
            array('name' => '多选框', 'key' => 'checkbox'),
            array('name' => '下拉框', 'key' => 'select'),
            array('name' => '隐藏', 'key' => 'hidden'),
            /*array('name' => '文件', 'key' => 'file'),
            array('name' => '时间', 'key' => 'date'),*/
        );
    }

    /**
     * 通过配置好的字段各属性来生成html
     * @param $configItemArr array('data_type'=>'数据类型','db_field_name'=>'数据库字段名','default'=>'默认值', 'is_input_hidden'=>'是不是hidden类型，如果是 则直接设置为hidden,这个只对date_type为date和string生效',)
     * @param array $valueList 设置Input的值 比如想把site_name的值为 DcrPHP系统 则传入传情为 array('site_name'=>'DcrPHP系统');
     * @param array $varList 外部变量列表，这个是为了实现var.abc这样的配置项 一般传get_defined_vars()
     * @param array $option 额外的设置在这 array('input_name_pre'=>'input的name加上统一的前缀','only_view'=>0 是不是只查看 默认是0:可以编辑)
     * @return mixed
     */
    public static function generalHtmlForItem(
        array $configItemArr,
        $valueList = array(),
        $varList = array(),
        $option = array()
    ) {
        foreach ($configItemArr as $itemKey => $itemInfo) {
            $keyList = self:: getFieldTypeList();
            $keyList = array_column($keyList, 'key');
            if (!in_array($itemInfo['data_type'], $keyList)) {
                continue;
            }
            $html = '';

            //默认或设置值
            //额外的配置，请看
            $default = $itemInfo['default_str'];
            /*if ('var.' == substr($default, 0, 4)) {
                $var = substr($default, 4);
                $default = $varList[$var];
            }*/
            //看下是不是{json}配置
            $defaultArr = json_decode($default, 1);
            if ($defaultArr) {
                #pr($defaultArr);
                switch ($defaultArr['type']) {
                    case 'config':
                        $default = config($defaultArr['name']);
                        break;
                    case 'var':
                        $default = $default = $varList[$defaultArr['name']];
                        break;
                    case 'database':
                        $databaseDataList = Db::select(array('table' => $defaultArr['table'],'limit' => $defaultArr['limit'],'where' => $defaultArr['where'],'order' => $defaultArr['order'],'group' => $defaultArr['group'],'col' => "{$defaultArr['key']},{$defaultArr['value']}",));
                        $default = array_column($databaseDataList, $defaultArr['value'], $defaultArr['key']);
                        break;
                }
            }

            //确定input值
            //var_dump($itemInfo['db_field_name']);
            if (is_array($valueList[$itemInfo['db_field_name']])) {
                $valueList[$itemInfo['db_field_name']] = implode(',', $valueList[$itemInfo['db_field_name']]);
            }
            $inputValue = isset($valueList[$itemInfo['db_field_name']]) ? $valueList[$itemInfo['db_field_name']] : $default;
            $inputNameId = $option['input_name_pre'] ? $option['input_name_pre'] . $itemInfo['db_field_name'] : $itemInfo['db_field_name'];
            //var_dump($inputValue);
            if ($option['only_view']) {
                $html = $inputValue;
            } else {
                switch ($itemInfo['data_type']) {
                    case 'text':
                        $html = Form::text()->class('input-text block')->name($inputNameId)->id($inputNameId)->value($inputValue)->html();
                        //$html = "<input class='input-text block' name='{$inputNameId}' id='{$inputNameId}' type='text' value='{$inputValue}'>";
                        break;
                    case 'hidden':
                        $html = Form::hidden()->name($inputNameId)->id($inputNameId)->value($inputValue)->html();
                        break;
                    case 'textarea':
                        $html = Form::textarea()->class('textarea radius')->name($inputNameId)->id($inputNameId)->value($inputValue)->html();
                        break;
                    case 'radio':
                        $clsLabel = Form::label()->class('mr-10');
                        $html = Form::radio()->itemLabel($clsLabel)->value($inputValue)->item($default)->name($inputNameId)->html();
                        break;
                    case 'checkbox':
                        if ("1" == $inputValue) {
                            $inputValue = '是';
                        }
                        $clsLabel = Form::label()->class('mr-10');
                        $html = Form::checkbox()->itemLabel($clsLabel)->value($inputValue)->item($default)->name($inputNameId)->html();
                        break;
                    case 'select':
                        $html = Form::select()->value($inputValue)->item($default)->id($inputNameId)->name($inputNameId)->html();
                        break;
                    default:
                        $html = '';
                        break;
                }
            }
            $configItemArr[$itemKey]['html'] = $html;
        }
        return $configItemArr;
    }

    /**
     * 通用的数据库表增改删 CUD:create update delete
     * @param $tableName 表名
     * @param $tablePreName 表前缀
     * @param $dbInfo 要添加或更新的数据，如果是删除，本字段为空
     * @param string $actionType 添加还是更新还是删除 add edit delete
     * @param array $option array('id'=>$id 如果是涉及到修改数据的话，要这个id,'check'=>array('a'=>array('type'=>requried a字段为必填), 'b'=>array('type'=>requried b字段为必填)))
     *
     * 案例
     *
     */
    public static function CUDDbInfo(
        $tableName,
        $tablePreName,
        $dbInfo,
        $actionType = 'insert',
        $option = array()
    ) {

        $tablePreName = '';
        if (!in_array($actionType, array('add', 'delete', 'edit'))) {
            throw new \Exception('当前action为' . $actionType . ',操作类型只允许insert update delete');
        }
        if (in_array($actionType, array('edit', 'delete')) && !isset($option['id'])) {
            throw new \Exception('如果是更新或删除，请设置主键id($option["id"])');
        }
        $result = 0;
        if ('delete' == $actionType) {
            //验证
            $info = DB::select(array(
                'table' => $tableName,
                'col' => $tablePreName . 'id',
                'where' => $tablePreName . "id={$option['id']}",
                'limit' => 1
            ));
            $info = current($info);

            if (!$info) {
                throw new \Exception('没有找到这个信息');
            }
            //逻辑
            $result = Db::delete($tableName, $tablePreName . "id={$option['id']}");
        } else {
            if ($option['check']) {
                foreach ($option['check'] as $fieldName => $detail) {
                    if ('required' == $detail['type'] && strlen($dbInfo[$fieldName]) < 1) {
                        throw new \Exception($fieldName . '-为必填项');
                    }
                    if ('number' == $detail['type'] && !is_numeric($dbInfo[$fieldName])) {
                        throw new \Exception($fieldName . '-为数字');
                    }
                }
            }

            //option the data 20200920
            foreach ($dbInfo as $key => $value) {
                if ('pdo_sqlite' == env('DB_TYPE')) {
                    $dbInfo[$key] = sqliteEscape($dbInfo[$key]);
                } else {
                    $dbInfo[$key] = addslashes($value);
                }
            }

            //处理
            if ('edit' == $actionType) {
                $result = Db::update($tableName, $dbInfo, $tablePreName . "id='{$option['id']}'");
            } else {
                if ('add' == $actionType) {
                    if (!isset($dbInfo['add_user_id'])) {
                        $dbInfo['add_user_id'] = session('userId');
                    }
                    if (!isset($dbInfo['zt_id'])) {
                        $dbInfo['zt_id'] = session('ztId');
                    }
                    $result = Db::insert($tableName, $dbInfo);
                }
            }
        }

        return Admin::commonReturn($result);
    }
}
