<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/18
 * Time: 14:04
 */

namespace app\Admin\Controller;

use app\Admin\Model\Admin;
use app\Admin\Model\Factory;
use app\Admin\Model\User as MUser;
use dcr\facade\Response;
use dcr\Safe;
use dcr\Session;
use dcr\View;
use Exception;
use Former\Facades\Former;
use Throwable;

class Index
{
    private $modelName = '首页';

    /**
     * 首页
     * @11log 这里改成@log可以看效果
     * @return mixed
     * @throws Exception
     */
    public function index()
    {
        //Log::systemLog('ok');
        /*cache('test_key', 111);
        var_dump( cache('test_key') ) ;
        exit;*/
        /*$userInfo = container('em')->find('\app\Model\Entity\Plugins', 10);
        dd($userInfo);
        dd($userInfo->getName());
        exit;*/
        /*$entityPlugins = new \app\Model\Entity\Plugins();
        $entityPlugins->setTitle('test');
        $entityPlugins->setAddTime(new \DateTime("now"));
        $entityPlugins->setUpdateTime(new \DateTime("now"));
        container('em')->persist($entityPlugins);
        container('em')->flush();
        exit;*/
        $assignData = array();
        $version = config('info.version');
        $appName = config('info.name');
        $assignData['version'] = $version;
        $assignData['app_name'] = $appName;
        $assignData['page_title'] = '首页';
        $assignData['page_model'] = $this->modelName;
        /*dd($assignData);
        exit;*/
        return Factory::renderPage('index/index', $assignData);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function welcome()
    {
        $assignData = array();
        $assignData['page_title'] = '欢迎页面';
        $assignData['page_model'] = $this->modelName;

        //获取用户信息
        $user = new MUser();
        $userInfo = $user->getInfo(Session::_get('username'));
        $assignData['user_info'] = $userInfo;
        $assignData['db_type'] = env('MYSQL_DRIVER', 'mysql');
        $version = config('info.version');
        $assignData['version'] = $version;

        return Factory::renderPage('index/welcome', $assignData);
    }

    /**
     * 退出
     */
    public function logout()
    {
        $user = new MUser();
        $user->logout();
        /*dd($_SESSION);
        exit;*/
        Response::_redirect('/admin');
    }

    /**
     * @param View $view
     * @return string
     * @throws Throwable
     */
    public function login(View $view)
    {
        $username = post('username');
        $password = post('password');
        $captcha = post('captcha');
        $admin = new Admin();

        //如果开启了验证码 则要判断对不对 判断验证码对不对
        $clsConfig = new \app\Model\Config();
        $captchaUse = $clsConfig->getSystemConfig('use_captcha');

        if ('是' == $captchaUse && empty(Session::_get('captcha'))) {
            $view->assign('error_msg', '系统没有生成验证码');
            $admin->common($view);
            return Factory::renderLogin($view);
        }
        if ('是' == $captchaUse && strtolower(Session::_get('captcha')) != strtolower($captcha)) {
            $view->assign('error_msg', '验证码不正确');
            $admin->common($view);
            return Factory::renderLogin($view);
        }

        //判断用户名
        $user = new MUser();
        $password = Safe::_encrypt($password);
        $yzResult = $user->check($username, $password);

        if ($yzResult['ack']) {
            //登陆后跳转
            $data = $yzResult['data'];
            $user->login($data['userId']);
            Response::_redirect('/admin');
        } else {
            $view->assign('error_msg', $yzResult['msg']);
            $admin->common($view);
            return Factory::renderLogin($view);
        }
    }
}
