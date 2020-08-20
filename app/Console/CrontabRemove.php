<?php

namespace app\Console;

use app\Model\Crontab;
use app\Model\Install;
use dcr\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CrontabRemove extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('crontab_name', InputArgument::REQUIRED, 'crontab name');
        $this->setDescription(
            "删除计划任务"
        );
        $this->setName('crontab:remove'); //console name:php dcrphp crontab:remove
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {
            $crontabName = $input->getArgument('crontab_name');
            $classFile = Crontab::getClassPath($crontabName);
            if (!file_exists($classFile)) {
                throw new \Exception('Crontab Name is not exists');
                exit;
            }

            @unlink($classFile);
            if (file_exists($classFile)) {
                throw new \Exception('Crontab remove failed, you can remove the file in app\Crontab');
                exit;
            }
            echo "remove crontab success";
            return 0;
        } catch (\Exception $e) {
            throw $e;
        }

        return 0;
    }
}
