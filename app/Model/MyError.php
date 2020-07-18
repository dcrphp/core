<?php

declare(strict_types=1);

namespace app\Model;

use dcr\facade\Log;

/**
 * 本类用来处理额外的错误，比如把错误发往日志中心。
 * Class MyError
 */
class MyError extends \Whoops\Handler\Handler
{

    public function handle()
    {
        // TODO: Implement handle() method.
        //系统日志

        if (config('log.log_enable')) {
            try {
                $logInfo = array(
                    'ack' => 0, //1或0 这是成功还是失败
                    'message' => $this->getException()->getMessage(),
                    'source' => 'dcrphp-error',
                    'line' => $this->getException()->getLine(),
                    'file_name' => $this->getException()->getFile(),
                );
                Log::systemLog($logInfo, 'critical', $this->getException()->getMessage(), config('log.error_driver'));
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}
