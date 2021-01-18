<?php

namespace app\Model;

use app\Model\Concerns\Model;
use dcr\facade\Db;

class Attribute implements Model
{

    /**
     * @param string $keywordGroup
     * @param int $id
     * @param string $keyword
     * @param string $value
     * @return mixed
     */
    public function getAttributeList(string $keywordGroup, int $id = 0, $keyword = '', $value = '')
    {
        $where = array();
        $where[] = "keyword_group='{$keywordGroup}'";
        if ($id) {
            $where[] = "data_id='{$id}'";
        }
        if ($keyword) {
            $where[] = "keyword='{$keyword}'";
        }
        if ($value) {
            $where[] = "value='{$value}'";
        }
        return DB::select(array('limit' => 1, 'table' => 'attribute', 'where' => $where));
    }

    /**
     * @param string $keywordGroup
     * @param int $id
     * @param string $keyword
     * @param string $value
     * @return bool|mixed
     * @throws \Exception
     */
    public function updateAttribute(string $keywordGroup, string $keyword, int $id, string $value)
    {
        $where = "keyword_group='{$keywordGroup}' and keyword='{$keyword}' and data_id={$id}";
        $hasInfo = Db::select(array('table' => 'attribute', 'where' => $where, 'col' => 'id'));
        $val = '';
        if ($hasInfo) {
            $val = DB::update('attribute', array('value' => $value), $where);
        } else {
            $dbInfo = array();
            $dbInfo['keyword_group'] = $keywordGroup;
            $dbInfo['keyword'] = $keyword;
            $dbInfo['data_id'] = $id;
            $dbInfo['value'] = $value;
            $val = DB::insert('attribute', $dbInfo);
        }
        return $val;
    }

    public function validate($entity)
    {
    }
}
