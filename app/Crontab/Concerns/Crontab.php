<?php

declare(strict_types=1);

namespace app\Crontab\Concerns;

abstract class Crontab
{
    public function getParams()
    {
        global $argv;
        $params = $argv;
        unset($params[0]);
        unset($params[1]);
        unset($params[2]);
        $params = array_merge($params);
        return $params;
    }

    abstract public function handler();
}
