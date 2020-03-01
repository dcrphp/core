<?php


namespace app\Model;

use Thamaraiselvam\MysqlImport\Import;

class Install
{
    /**
     * 执行某个目录下的sql文件
     * @param $sqlPath
     * @return bool
     */
    function executeSqlFiles($sqlPath)
    {
        $host = env('MYSQL_DB_HOST');
        $port = env('MYSQL_DB_PORT');
        $username = env('MYSQL_DB_USERNAME');
        $password = env('MYSQL_DB_PASSWORD');
        $database = env('MYSQL_DB_DATABASE');

        $sqlFileList = scandir($sqlPath);
        foreach ($sqlFileList as $sqlFile) {
            if (pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                $sqlFilename = $sqlPath . DS . $sqlFile;
                new Import($sqlFilename, $username, $password, $database, $host . ':' . $port);
            }
        }

        return true;
    }
}