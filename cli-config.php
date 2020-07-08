<?php
declare(strict_types=1);
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/27
 * Time: 21:39
 */

//phpinfo();
//namespace dcr;

use Doctrine\ORM\Tools\Console\ConsoleRunner;

header('Access-Control-Allow-Origin:*');
require_once __DIR__ . '/dcr/bootstrap/init.php';
$em = container('em');
return ConsoleRunner::createHelperSet($em);
