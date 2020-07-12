<?php
declare(strict_types=1);


namespace dcr\facade;

use DcrPHP\Log\SystemLogger;

/**
 * 日志操作
 * Class Log
 * @package dcr\facade
 */
class Log
{
    /**
     * 写系统日志
     * @param $logInfo 内容 可以是数组 也可以是字符串 如果是数组必要字段是message
     * @param string $level 级别 默认是:info
     * @param string $title 标题 默认是:日志
     * @param string $handlerName 处理handler 默认用配置里的log.system_driver
     * @throws \Exception
     */
    public static function systemLog($logInfo, $level = 'info', $title = '日志', $handlerName = '')
    {
        $logDetail = array();
        if (!is_array($logInfo)) {
            $logDetail['message'] = $logInfo;
        } else {
            $logDetail = $logInfo;
        }
        //自动补充字段
        $logDetail['ack'] = is_array($logInfo) && $logInfo['ack'] ? $logInfo['ack'] : 1;
        $logDetail['source'] = is_array($logInfo) && $logInfo['source'] ? $logInfo['source'] : 'dcrphp';
        $logDetail['add_time'] = is_array($logInfo) && $logInfo['add_time'] ? $logInfo['add_time'] : date('Y-m-d H:i:s');
        $logDetail['level'] = $level;

        $handlerName = $handlerName ? $handlerName : config('log.system_driver');
        $clsSystemLogger = new SystemLogger(CONFIG_DIR . DS . 'log.php'); //配置文件
        $clsSystemLogger->addHandler($handlerName);//添加额外的处理
        $clsSystemLogger->setTitle($title);
        $clsSystemLogger->setLogInfo($logDetail);
        $clsSystemLogger->$level();
    }
}
