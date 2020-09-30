<?php

namespace app\Console;

use app\Model\Install;
use Psy\Shell;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleShell extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('console:shell'); //console name:php dcrphp console:shell
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {
            $sh = new Shell();
            $sh->run();
        } catch (\Exception $e) {
            throw $e;
        }

        return 0;
    }
}
