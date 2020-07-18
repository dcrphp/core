<?php

/**
 * 登陆后台测试链接是否正常
 * 可用:https://symfony.com/doc/current/components/browser_kit.html
 */

namespace test;

require_once __DIR__ . '/../dcr/bootstrap/init.php';

use PHPUnit\Framework\TestCase;
use QL\QueryList;

class TestWeb extends TestCase
{

    public function testWeb()
    {
        //登陆
        $ql = QueryList::post('http://127.0.0.1/admin/index/login', [
            'username' => 'admin',
            'password' => '123456'
        ]);
        $html = $ql->getHtml();
        $this->assertRegExp('/我的桌面/', $html);

        $html = $ql->get('http://127.0.0.1/admin/index/index')->getHtml();
        $this->assertRegExp('/我的桌面/', $html);

        try {
            //有些要附加参数才能自动化访问
            $additionCs = array(
                'passwordchangeview' => '?user_id=1',
                'roleeditpermissionview' => '?role_id=1',
                'configlistitemview' => '/1',
                'configview' => '/1',
                'tableeditinfoview' => '/1',
                'tableediteditview' => '/edit/table_edit/2',
                'tableeditlistview' => '/table_edit'
            );
            //幸好当初定好了命名规则，这里统一定查下有没有非正常的页面
            //获取admin下的所有view看下
            $adminPath = ROOT_APP . DS . 'Admin' . DS . 'Controller';
            $classFileList = scandir($adminPath);
            foreach ($classFileList as $classFileName) {
                if (!in_array($classFileName, array('.', '..'))) {
                    $fileInfo = pathinfo($classFileName);
                    $className = 'app\\Admin\\Controller\\' . $fileInfo['filename'];
                    $reflector = new \ReflectionClass($className);
                    $methodList = $reflector->getMethods();
                    $classNameArr = explode(DS, strtolower($className));
                    if (1 == count($classNameArr)) {
                        $classNameArr = explode('\\', strtolower($className));
                    }
                    foreach ($methodList as $methodDetail) {
                        $methodNameLower = strtolower($methodDetail->name);
                        if ('view' == substr($methodNameLower, -4)) {
                            $viewUrl = 'http://127.0.0.1/' . $classNameArr[1] . '/' . $classNameArr[3] . '/' . $methodNameLower . $additionCs[$methodNameLower];
                            /*dd($className);
                            dd($classNameArr);
                            echo "\r\n" . $methodDetail->name;
                            echo "\r\n" . $viewUrl . "\r\n";*/
                            //exit;
                            $html = $ql->get($viewUrl)->getHtml();
                            /*echo $html;
                            break;*/
                            if (strlen($html) < 1) {
                                echo $viewUrl . ':is empty';
                                echo "\r\n";
                            }

                            $this->assertRegExp('/stylesheet/', $html);
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
        }
    }
}
