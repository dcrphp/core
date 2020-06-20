<?php
declare(strict_types=1);

namespace dcr\facade;

class Db
{

    public static function getConnection()
    {
        $entityManager = container('em');
        return $entityManager->getConnection();
    }
    public static function createQueryBuilder()
    {
        return self::getConnection()->createQueryBuilder();
    }
    /**
     * @param $option 参数为:
     * table:表名
     * where:数组或字符串
     * limit:
     * order:
     * offset:
     * group:
     * join: 多个请用join数组 比如 array(array(),array()),如果只是一个则一个即可array() 格式: array('type'=> 类型, 'table'=> 连接的表 'condition'=> 连接条件)
     * @return mixed
     * @throws
     */
    public static function select($option)
    {

        $col = $option['col'] ? $option['col'] : array('*');
        if (!is_array($col)) {
            $col = array($col);
        }
        $select = self::createQueryBuilder();

        $select->from($option['table'])->select($col);
        if ($option['order']) {
            //正常是array('field'=>'id','order'=>'asc'),这里兼容直接写的比如 'id asc'
            $orderConfig = array();
            if (is_array($option['order'])) {
                $orderConfig = $option['order'];
            } else {
                if ('asc' == strtolower(substr($option['order'], -3))) {
                    $orderConfig['field'] = substr($option['order'], 0, strlen($option['order']) - 4);
                    $orderConfig['order'] = 'asc';
                }
                if ('desc' == strtolower(substr($option['order'], -4))) {
                    $orderConfig['field'] = substr($option['order'], 0, strlen($option['order']) - 5);
                    $orderConfig['order'] = 'desc';
                }
            }

            $select->orderBy($orderConfig['field'], $orderConfig['order']);
        }
        if ($option['limit']) {
            $select->setMaxResults($option['limit']);
        }
        if ($option['offset']) {
            $select->setFirstResult($option['offset']);
        }
        if ($option['group']) {
            $select->group($option['group']);
        }
        if ($option['join']) {
            if (3 == count($option['join']) && $option['join']['type']) {
                $option['join'] = array($option['join']);
            }
            //dd($option);
            foreach ($option['join'] as $joinDetail) {
                $joinMethod = 'innerJoin';
                switch ($joinDetail['type']) {
                    case 'left':
                        $joinMethod = 'leftJoin';
                        break;
                    case 'right':
                        $joinMethod = 'rightJoin';
                        break;
                }
                //dd($joinDetail);
                //exit;
                //$select->$joinMethod($joinDetail['table'], $joinDetail['type'], $joinDetail['condition']);
                $select->$joinMethod($option['table'], $joinDetail['table'], '', $joinDetail['condition']);
            }
        }
        //dd($option);
        $whereStr = '';
        if ($option['where']) {
            if (is_array($option['where'])) {
                $whereStr = implode(' and ', $option['where']);
            } else {
                $whereStr = $option['where'];
            }
            $select->where($whereStr);
        }
        $sql = $select->getSQL();

        return self::getConnection()->fetchAll($sql);
    }

    /**
     * @param $sql
     * @return mixed
     */
    public static function exec($sql)
    {
        return self::getConnection()->exec($sql);
    }

    /**
     * @param $sql
     * @return mixed
     */
    public static function query($sql)
    {
        return self::getConnection()->query($sql)->fetchAll();
    }

    /**
     * @param $table
     * @param $info
     * @param $where
     * @return mixed
     */
    public static function update($table, $info, $where)
    {
        $update = self::createQueryBuilder();
        $update = $update->update($table);
        foreach ($info as $key => $value) {
            $update = $update->set($key, "'{$value}'");
        }
        $update = $update->where($where);
        $sql = $update->getSql();
        return self::exec($sql);
    }

    /**
     * @param $table
     * @param $info
     * @return mixed
     */
    public static function insert($table, $info)
    {
        $insert = self::createQueryBuilder();
        $insert = $insert->insert($table);
        foreach ($info as $key => $value) {
            $insert = $insert->setValue($key, "'{$value}'");
        }
        $sql = $insert->getSql();
        /*echo $sql;
        exit;*/
        return self::exec($sql);
    }

    /**
     * @param $table
     * @param $where
     * @return mixed
     */
    public static function delete($table, $where)
    {
        $delete = self::createQueryBuilder();
        $delete = $delete->delete($table);
        $delete = $delete->where($where);
        $sql = $delete->getSql();
        return self::exec($sql);
    }
}
