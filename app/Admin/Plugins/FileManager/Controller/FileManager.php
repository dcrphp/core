<?php

namespace app\Admin\Plugins\FileManager\Controller;

use app\Admin\Model\Plugins;
use DcrPHP\File\Directory;
use DcrPHP\File\Info;

class FileManager extends Plugins
{

    public function index($view)
    {
        if (!env('PLUGIN_FILE_MANAGER_ENABLE')) {
            exit('因为安全原因，系统默认关闭，请联系管理员在evn中把PLUGIN_FILE_MANAGER_ENABLE设置为1');
        }

        //文件列表
        $dirPath = realpath(ROOT_APP . DS . '..');
        try {
            $clsDirectory = new Directory($dirPath);
            $list = $clsDirectory->getList();

            $listFinal = array();
            foreach ($list as $detail) {
                $info = array();
                $clsInfo = new Info($detail['path']);
                $info['path'] = $clsInfo->getPath();
                $info['type'] = $clsInfo->getType();
                $info['base_name'] = $clsInfo->getBaseName();
                $info['file_name'] = $clsInfo->getFileName();
                $info['extension_name:'] = $clsInfo->getExtensionName();
                $info['size'] = $clsInfo->getSize('kb') . 'kb';
                $info['lastmod'] = date('Y-m-d H:i:s', $clsInfo->getLastMod());
                $listFinal[] = $info;
            }
            $view->assign('directory_path', $dirPath);
            $view->assign('list', $listFinal);
        } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
        }
    }
}
