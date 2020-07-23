<?php

namespace app\Admin\Plugins\DbManager\Controller;

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
