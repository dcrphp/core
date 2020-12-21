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
     * @return mixed
     */
    public function getAttributeList(string $keywordGroup,int $id, $keyword = '')
    {
        $where = array();
        $where[] = "keyword_group='{$keywordGroup}'";
        $where[] = "data_id='{$id}'";
        if ($keyword) {
            $where[] = "keyword='{$keyword}'";
        }
        return DB::select(array('limit' => 1, 'table' => 'attribute', 'where' => $where));
    }


    /**
     * @param string $keywordGroup
     * @param string $keyword
     * @param int $id
     * @param string $value
     * @return bool|mixed
     * @throws \Exception
     */
    public function updateAttribute(string $keywordGroup, string $keyword, int $id, string $value)
    {
        return DB::update('attribute', array('value' => $value), "keyword_group='{$keywordGroup}' and keyword='{$keyword}' and data_id={$id}");
    }

    public function validate($entity)
    {

    }
}