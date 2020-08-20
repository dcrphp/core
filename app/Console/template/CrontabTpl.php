<?php

declare(strict_types=1);

namespace app\Crontab;

use app\Crontab\Concerns\Crontab;

class CrontabTpl extends Crontab
{
    public function handler()
    {
        $params = $this->getParams();
        echo 'params:';
        echo PHP_EOL;
        print_r($params);
        echo PHP_EOL;
        echo 'here is a example';
        return array('ack' => 1);
    }
}
