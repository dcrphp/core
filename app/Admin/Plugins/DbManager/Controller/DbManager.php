<?php

namespace app\Admin\Plugins\DbManager\Controller;

use app\Admin\Model\Admin;
use app\Admin\Model\Plugins;
use app\Model\Tools;
use dcr\facade\Db;

class DbManager extends Plugins
{
    public function index($view)
    {
        if (!env('DBMANAGER_ENABLE')) {
            exit('因为安全原因，系统默认关闭，请联系管理员在evn中把DBMANAGER_ENABLE设置为1');
        }
        //得出支持的字段类似
        $typeList = \Doctrine\DBAL\Types\Type::getTypesMap();
        $typeNameList = array_keys($typeList);
        $view->assign('type_list', $typeNameList);
    }

    public function createTable()
    {
        //得出field
        $fieldArr = array();
        $tableName = post('table_name');
        $field = post('field');
        $length = post('length');
        $type = post('type');
        $default = post('default');
        $comment = post('comment');
        $tableComment = post('table_comment');

        Db::beginTransaction();

        $schema = new \Doctrine\DBAL\Schema\Schema();
        $clsTable = $schema->createTable($tableName);
        $clsTable->setComment($tableComment);
        $clsTable->addColumn("id", "integer", array("notnull" => true, 'autoincrement' => true));
        $clsTable->addColumn("add_time", "datetime", array("notnull" => true, 'default' => 'CURRENT_TIMESTAMP'));
        $clsTable->addColumn("is_approval", "boolean", array("notnull" => true, 'default' => '1', 'length' => 1));
        $clsTable->addColumn("add_user_id", "smallint", array("notnull" => true, 'default' => '0', 'length' => 6));
        $clsTable->addColumn("zt_id", "smallint", array("notnull" => true, 'default' => '0', 'length' => 6));
        $clsTable->setPrimaryKey(array("id"));
        $clsTable->addOption('engine', post('engine'));
        $clsTable->addOption('collate', 'utf8_general_ci');
        $clsTable->addOption('charset', 'utf8');

        foreach ($field as $id => $filedName) {
            $option = array();
            $option['notnull'] = true;
            $option['default'] = $default[$id];
            $length[$id] ? $option['length'] = $length[$id] : '';
            $comment[$id] ? $option['comment'] = $comment[$id] : '';
            $clsTable->addColumn($filedName, $type[$id], $option);
        }

        //创建索引
        foreach (post('index') as $id => $indexType) {
            $functionName = 'index' == $indexType ? 'addIndex' : 'addUniqueIndex';
            $clsTable->$functionName(array($field[$id]));
        }
        $sqlList = $schema->toSql(Db::getConnection()->getDatabasePlatform());
        $sql = current($sqlList);
        Db::exec($sql);
        Db::commit();

        //生成单表 这里有事务。所以在上面结束
        if (post('auto_general_table_edit')) {
            $clsTools = new Tools();
            $clsTools->tableEditGenerate('单表中心', $tableName, $tableName, $tableComment ? $tableComment : $tableName);
        }

        return Admin::commonReturn(1);
    }
    /**
     * 执行sql
     * @param $view
     * @return array
     */
    public function execute($view)
    {
        $sql = post('sql');
        $type = post('type');
        $functionName = 'query';
        if ('not_select' == $type) {
            $functionName = 'exec';
        }
        $result = Db::$functionName($sql);

        if ($result && 'select' == $type) {
            $list = $result;
            $result = '<table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr>';
            $cols = array_keys($list[0]); //列名
            foreach ($cols as $col) {
                $result .= "<th width=\"100\">{$col}</th>";
            }
            $result .= '</tr></thead>';
            $result .= '<tbody>';
            foreach ($list as $value) {
                foreach ($cols as $col) {
                    $result .= "<td>{$value[$col]}</td>";
                }
            }
            $result .= '</tbody></table>';
        }
        return array('ack' => 1, 'data' => $result);
    }
}
