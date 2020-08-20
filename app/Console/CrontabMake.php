<?php

namespace app\Console;

use app\Model\Crontab;
use app\Model\Install;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrontabMake extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('crontab_name', InputArgument::REQUIRED, 'crontab name');
        $this->setDescription(
            "创建计划任务,产生在app\\Crontab，如：php dcrphp crontab:make test，执行:php dcrphp help crontab:execute"
        );
        $this->setName('crontab:make'); //console name:php dcrphp crontab:make
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $crontabName = $input->getArgument('crontab_name');

            $classFile = Crontab::getClassPath($crontabName);
            if (file_exists($classFile)) {
                throw new \Exception(
                    'Crontat exists,you can remove this console by php dcrphp crontab:remove ' . $input->getArgument(
                        'crontab_name'
                    )
                );
                exit;
            }

            $tpl = file_get_contents(__DIR__ . DS . 'template' . DS . 'CrontabTpl.php');

            //replace
            $tpl = str_replace('CrontabTpl', $crontabName, $tpl);

            try {
                file_put_contents($classFile, $tpl);
                echo "We make the crontab,you can edit it:app\\Crontab\\{$crontabName}";
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return 0;
    }
}
