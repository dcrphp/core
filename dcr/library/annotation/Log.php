<?php
declare(strict_types=1);

namespace dcr\annotation;

use DcrPHP\Log\Log as DLog;
use DcrPHP\Log\SystemLogger;

class Log
{
    protected $parameter;
    protected $annotations; //这个类记录了类名和function名

    /**
     * @param $annotations
     */
    public function setAnnotations($annotations)
    {
        $this->annotations = $annotations;
    }

    public function setParameter($parameter)
    {
        $this->parameter = $parameter;
    }

    public function handler()
    {

        //默认数据
        $type = $this->parameter['type'] ? $this->parameter['type'] : config('log.system_driver');
        $level = $this->parameter['level'] ? $this->parameter['level'] : 'info';
        $recordStr = $this->parameter['record'] ? $this->parameter['record'] : 'run_time';
        $recordList = explode(',', $recordStr);
        //dd($recordList);

        //日志内容
        $contentArr = array();
        foreach ($recordList as $record) {
            switch ($record) {
                case 'run_time':
                    $contentArr[] = "run:{$this->annotations->getRunTime()}s";
                    break;
                case 'return_var':
                    if (is_array($this->annotations->getReturnData())) {
                        $contentArr[] = "return:" . json_encode($this->annotations->getReturnData());
                    } else {
                        $contentArr[] = "return:{$this->annotations->getReturnData()}";
                    }
                    break;
            }
        }
        $content = $this->annotations->getClassName() . "->" . $this->annotations->getMethodName();

        //记录日志


        $clsSystemLogger = new SystemLogger(CONFIG_DIR . DS . 'log.php'); //配置文件
        $clsSystemLogger->addHandler($type);
        $clsSystemLogger->setLogInfo(
            array(
                'ack' => 1, //1或0 这是成功还是失败
                'level' => $level, //warning info debug notice critical emergency
                'add_time' => date('Y-m-d H:i:s'),
                'message' => json_encode($contentArr),
                'source' => 'dcrphp',
                'class'=> $this->annotations->getClassName(),
                'method'=> $this->annotations->getMethodName(),
            )
        );
        $clsSystemLogger->$level();
    }
}