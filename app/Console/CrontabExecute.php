<?php

namespace app\Console;

use app\Model\Crontab;
use app\Model\Install;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrontabExecute extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('crontab:execute'); //console name:php dcrphp crontab:execute
        $this->addArgument('crontab_name', InputArgument::REQUIRED, 'crontab name');
        $this->addArgument('argv1', InputArgument::OPTIONAL, 'param1');
        $this->addArgument('argv2', InputArgument::OPTIONAL, 'param2');
        $this->addArgument('argv3', InputArgument::OPTIONAL, 'param3');
        $this->addArgument('argv4', InputArgument::OPTIONAL, 'param4');
        $this->addArgument('argv5', InputArgument::OPTIONAL, 'param5');
        $this->setDescription(
            "执行计划任务,添加:php dcrphp crontab:make test,后[php dcrphp crontab:execute test arg1 arg2]添加到如linux的crontab中"
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $processId = time() . mt_rand(10000, 99999);
        $crontabName = $input->getArgument('crontab_name');
        #找到处理的类
        $clsCrontab = new Crontab($processId, $crontabName);
        try {
            #记录开始
            $clsCrontab->recordStart();
            #执行
            $clsCrontab->handler();
            #记录结束
            $clsCrontab->recordEnd();
            #返回
        } catch (\Exception $e) {
            $clsCrontab->recordEnd($e->getMessage());
            throw $e;
        }

        return 0;
    }
}
