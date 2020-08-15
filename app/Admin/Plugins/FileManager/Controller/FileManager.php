<?php

namespace app\Admin\Plugins\FileManager\Controller;

use app\Admin\Model\Plugins;
use Symfony\Component\Finder\Finder;

class FileManager extends Plugins
{

    public function index($view)
    {
        if (!env('PLUGIN_FILE_MANAGER_ENABLE')) {
            exit('因为安全原因，系统默认关闭，请联系管理员在evn中把PLUGIN_FILE_MANAGER_ENABLE设置为1');
        }

        //文件列表
        $finder = new Finder();
        $finder->in(ROOT_APP . DS . '..');

        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
            $fileNameWithExtension = $file->getRelativePathname();
            echo $absoluteFilePath;
            echo $fileNameWithExtension;

            // ...
        }
        exit;
    }
}
