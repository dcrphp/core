<?php

declare(strict_types=1);

namespace dcr\annotation;

use dcr\facade\Log as FLog;

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

        //记录日志
        $title = $this->annotations->getClassName() . "->" . $this->annotations->getMethodName();
        $logInfo = array(
            'message' => json_encode($contentArr),
            'class' => $this->annotations->getClassName(),
            'method' => $this->annotations->getMethodName(),
        );
        try {
            FLog::systemLog($logInfo, $level, $title, $type);
        } catch (\Exception $e) {
        }
    }
}
