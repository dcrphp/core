<?php
declare(strict_types=1);

namespace dcr\annotation;

use DcrPHP\Log\Log as DLog;

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
        $clsLog = new DLog();

        //默认数据
        $type = $this->parameter['type'] ? $this->parameter['type'] : env('LOG_DRIVER');
        $level = $this->parameter['level'] ? $this->parameter['level'] : 'info';
        $recordStr = $this->parameter['record'] ? $this->parameter['record'] : 'run_time,return_var';
        $recordList = explode(',', $recordStr);
        //dd($recordList);
        //得出内容来
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

        $clsLog->setConfigFile(CONFIG_DIR . DS . 'log.php');
        $clsLog->addHandler($type); //记录在file中
        $clsLog->init();
        $clsLog->$level($content . "'s result:" . json_encode($contentArr));
        //$clsLog->warning('a');
    }
}