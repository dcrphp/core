<?php

namespace app\Admin\Plugins\DbManager\Controller;

use app\Admin\Model\Admin;
use app\Admin\Model\Factory;
use app\Admin\Model\Plugins;
use dcr\facade\Db;

class DbManager extends Plugins
{
    public function index($view)
    {
        if (!env('DBMANAGER_ENABLE')) {
            exit('因为安全原因，系统默认关闭，请联系管理员在evn中把DBMANAGER_ENABLE设置为1');
        }
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

        foreach ($field as $id => $filedName) {
            $lengthStr = $length[$id] ? '(' . $length[$id] . ')' : '';
            $comment = $comment ? " comment '{$comment[$id]}'" : '';
            $fieldTmp = "`{$filedName}` {$type[$id]}{$lengthStr} NOT NULL default '{$default[$id]}' {$comment}";
            $fieldArr[] = $fieldTmp;
        }
        $fieldStr = implode(',', $fieldArr) . ',';

        $sqlTpl = "CREATE TABLE `table_name_tpl` (`id` int(11) NOT NULL AUTO_INCREMENT,`add_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,`update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,`is_approval` tinyint(1) NOT NULL default 1,`add_user_id` smallint(6) NOT NULL default 0,`zt_id` smallint(6) NOT NULL default 1, field_tpl PRIMARY KEY (`id`) ) ENGINE=engine_tpl DEFAULT CHARSET=utf8 COLLATE = utf8_general_ci COMMENT = 'table_comment_tpl';";
        $sqlTpl = str_replace('table_name_tpl', $tableName, $sqlTpl);
        $sqlTpl = str_replace('table_comment_tpl', post('table_comment'), $sqlTpl);
        $sqlTpl = str_replace('engine_tpl', post('engine'), $sqlTpl);
        if ('pdo_sqlite' == env('DB_TYPE')) {
            $sqlTpl = str_replace('AUTO_INCREMENT', 'AUTOINCREMENT', $sqlTpl);
        }
        $createSql = str_replace('field_tpl', $fieldStr, $sqlTpl);
        Db::beginTransaction();
        Db::exec($createSql);

        //创建索引
        foreach (post('index') as $id => $indexType) {
            $indexType = 'index' == $indexType ? 'index' : 'unique index';
            $indexPrefix = 'index' == $indexType ? 'idx' : 'uq';
            $indexName = "{$indexPrefix}_{$tableName}_{$field[$id]}";
            $indexSql = "create {$indexType} {$indexName} on {$tableName}({$field[$id]});";
            Db::exec($indexSql);
        }
        Db::commit();

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
