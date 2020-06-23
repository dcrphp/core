<?php
declare(strict_types=1);

namespace dcr\facade;

class Db
{

    protected static $lastErrorCode;
    protected static $lastErrorInfo;
    protected static $lastSql;

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
     * @throws \Exception
     */
    public static function exec($sql)
    {
        self::$lastSql = $sql;
        $result = self::getConnection()->exec($sql);
        self::recordError(self::getConnection());

        //前面有错误会直接拦截 这里返回true
        return true;
    }

    /**
     * @param $sql
     * @return mixed
     * @throws \Exception
     */
    public static function query($sql)
    {
        self::$lastSql = $sql;
        $result = self::getConnection()->query($sql);
        self::recordError(self::getConnection());
        return self::getConnection()->query($sql)->fetchAll();

        return $result->fetchAll();
    }

    /**
     * @param $table
     * @param $info
     * @param $where
     * @return mixed
     * @throws \Exception
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
     * @throws \Exception
     */
    public static function insert($table, $info)
    {
        $insert = self::createQueryBuilder();
        $insert = $insert->insert($table);
        foreach ($info as $key => $value) {
            $insert = $insert->setValue($key, "'{$value}'");
        }
        $sql = $insert->getSql();
        self::exec($sql);
        /*echo $sql;
        exit;*/
        return self::getConnection()->lastInsertId();
    }

    /**
     * @param $table
     * @param $where
     * @return mixed
     * @throws \Exception
     */
    public static function delete($table, $where)
    {
        $delete = self::createQueryBuilder();
        $delete = $delete->delete($table);
        $delete = $delete->where($where);
        $sql = $delete->getSql();
        return self::exec($sql);
    }

    public static function beginTransaction()
    {
        self::getConnection()->beginTransaction();
    }

    public static function commit()
    {
        self::getConnection()->commit();
    }

    public static function rollback()
    {
        self::getConnection()->rollback();
    }

    public static function getLastSql()
    {
        return self::$lastSql;
    }

    /**
     * 显示或记录错误 如果有错误 这里会处理
     * @param $conn
     * @throws \Exception
     */
    private static function recordError($conn)
    {
        self::$lastErrorCode = $conn->errorCode();
        self::$lastErrorInfo = $conn->errorInfo();
        if ($conn->errorCode() != '0000') {
            $errorInfo = self::getError();
            $sql = self::getLastSql();
            $msg = $sql ? 'Sql是:' . $sql . ',' : '';
            throw new \Exception($msg . $errorInfo['msg']);
        }
    }

    public static function getError()
    {
        $conn = self::getConnection();
        return array('code' => $conn->errorCode(), 'msg' => implode(',', $conn->errorInfo()));
    }
}
