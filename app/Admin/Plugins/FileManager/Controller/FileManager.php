<?php

namespace app\Admin\Plugins\FileManager\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Plugins;
use DcrPHP\File\Directory;
use DcrPHP\File\File;
use DcrPHP\File\Info;

class FileManager extends Plugins
{
    private $backupDir = ROOT_APP . DS . 'Admin' . DS . 'Plugins' . DS . 'FileManager' . DS . 'BackupFile';

    /**
     * @param $path
     * @throws \Exception
     */
    public function checkPath($path)
    {
        $rootPath = realpath(ROOT_APP . DS . '..');
        if (strlen($path) < strlen($rootPath)) {
            throw new \Exception('不允许改根目录上级的文件或目录');
        }

        //vendor和plugins不能修改
        $banDir = array(
            'Admin' . DS . 'Plugins',
            'vendor',
            'env',
        );
        foreach ($banDir as $banDirDetail) {
            if (strstr($path, $banDirDetail)) {
                throw new \Exception('不允许改本目录或文件:' . $banDirDetail);
            }
        }
    }

    /**
     * 格式化请求里的地址
     * @param $path
     */
    public function formatPath($path)
    {
        $path = str_replace('&amp;', DS, $path);
        $path = str_replace('&', DS, $path);
        return $path;
    }

    public function remove()
    {
        $path = post('path');
        $path = $this->formatPath($path);
        $clsFile = new File();
        $clsFile->remove($path);

        return array('ack' => 1, 'msg' => '删除完成');
    }

    public function createFile()
    {
        $dirPath = post('dir_path');
        $name = post('name');
        $filePath = $dirPath . DS . $name;
        $filePath = $this->formatPath($filePath);
        $clsFile = new File();
        $clsFile->touch($filePath);

        return array('ack' => 1);
    }

    public function createDir()
    {
        $dirPath = post('dir_path');
        $name = post('name');
        $newDirPath = $dirPath . DS . $name;
        $newDirPath = $this->formatPath($newDirPath);
        $clsFile = new File();
        $clsFile->mkdir($newDirPath);

        return array('ack' => 1);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function save()
    {
        $content = post('content');
        $savePath = post('save_path');
        $savePath = str_replace('&amp;', DS, $savePath);
        $this->checkPath($savePath);

        //备份文件
        $clsInfo = new Info($savePath);
        $clsFile = new File();
        $backupFilePath = $this->backupDir . DS . $clsInfo->getFileName() . '-' . date('Y-m-d-H-i-s') . '.' . $clsInfo->getExtensionName();
        $clsFile->copy($savePath, $backupFilePath);

        try {
            file_put_contents($savePath, $content);
        } catch (\Exception $e) {
            throw new \Exception('保存失败' . $e->getMessage());
        }

        return array('ack' => 1, 'msg' => '保存完成:' . date('Y-m-d H:i:s') . ',原始文件备份在FileManager/BackupFile');
    }

    public function index($view)
    {
        if (!env('PLUGIN_FILE_MANAGER_ENABLE')) {
            exit('因为安全原因，系统默认关闭，请联系管理员在evn中把PLUGIN_FILE_MANAGER_ENABLE设置为1');
        }

        //文件列表
        if (get('path')) {
            $path = realpath(get('path'));
        } else {
            $path = realpath(ROOT_APP . DS . '..');
        }
        $this->checkPath($path);
        $savePath = str_replace(DS, '&', $path);
        $view->assign('save_path', $savePath);
        $view->assign('path', $path);

        $clsInfo = new Info($path);
        if ('file' == $clsInfo->getType()) {
            $indexView = 'file_edit';
            $clsPlugins = new Plugins();
            $pluginName = 'FileManager';
            $pluginDir = $clsPlugins->getPluginDir($pluginName);
            $viewDir = $pluginDir . DS . 'View';

            $assignData = array();
            $assignData['page_title'] = '编辑内容';
            $assignData['page_model'] = '系统工具';

            //得出内容
            $path = $clsInfo->getPath();
            $content = file_get_contents($path);
            $assignData['content'] = $content;

            echo Factory::renderPage('file-edit', $assignData, $viewDir);
            exit;
        }

        try {
            $clsDirectory = new Directory($path);
            $list = $clsDirectory->getList();
            $listColumn = array_column($list, null, 'name');
            sort($listColumn);
            array_multisort($listColumn, SORT_ASC, $list);

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
            $view->assign('list', $listFinal);
        } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
        }
    }
}
