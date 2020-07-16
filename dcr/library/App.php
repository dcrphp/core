<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 19:58
 */

namespace dcr;

use dcr\route\RuleItem;
use DcrPHP\Annotations\Annotations;
use DcrPHP\Cache\Cache;
use DcrPHP\Config\Config;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class App
{
    /**
     * @var $phpSapiName php运行模式
     */
    public static $phpSapiName;

    /**
     * 自动加载类
     */
    public static function autoLoadClasses()
    {
        spl_autoload_register(array('\dcr\ClassLoader', 'loadClasses'), true, true);
    }


    /**
     * 初始化entity manager
     */
    public static function initEntityManager()
    {
        ENV::init();
        self::initConfig();
        $container = container();

        //orm加载
        $ormConfig = Setup::createAnnotationMetadataConfiguration(
            array(config('app.entity_dir')),
            true,
            null,
            null,
            false
        );
        //$ormConfig->setSecondLevelCacheEnabled(false);
        $dbDriver = config('database.type');
        $dbConn = config('database.' . $dbDriver);
        $dbConn['driver'] = $dbDriver;

        try {
            $entityManager = \Doctrine\ORM\EntityManager::create($dbConn, $ormConfig);
            //$entityManager->getConnection()
            $container->instance('entity_manager', $entityManager);
            $container->instance('em', $entityManager);
        } catch (ORMException $e) {
            throw $e;
        }
    }

    public static function initConfig()
    {
        $container = container();
        //加载配置
        $clsConfig = new Config(CONFIG_DIR);
        //$clsConfig->addDirectory(CONFIG_DIR);
        $clsConfig->setDriver('php');//解析php格式的
        $clsConfig->init();
        $container->instance(\DcrPHP\Config\Config::class, $clsConfig);
        return $clsConfig;
    }

    public static function init()
    {
        self::$phpSapiName = php_sapi_name();
        self::autoLoadClasses();
        Error::init();
        Env::init();
        $container = container();

        $clsConfig = self::initConfig();

        //加载缓存
        if (env('CACHE_ENABLE')) {
            $clsCache = new Cache();
            $clsCache->setConfigFile(CONFIG_DIR . DS . 'cache.php');
            $clsCache->init();
            $container->instance($clsConfig->get('app.alias.cache'), $clsCache);
        }

        $container->autoBind();
        Session::init();
        // set default zt_id
        Session::_set('ztId', 1);

        //程序测试与否
        if (config('app.debug')) {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            @ini_set('display_errors', 'on');
        } else {
            @ini_set('display_errors', 'off');
        }

        self::initEntityManager();

        //设置时区
        date_default_timezone_set(config('app.default_timezone'));

        //如果是命令行就直接返回
        $result = '';
        if ('cli' == APP::$phpSapiName) {
            $result = '';
        } else {
            //开始处理request
            $request = Request::getInstance();
            $container->instance('request', $request);

            $route = container('route');
            //把url解析为ruleItem
            $ruleItem = $route->addRuleFromRequest($request);

            $result = self::exec($ruleItem);
        }

        return new Response($result);
    }

    public static function exec(RuleItem $ruleItem)
    {
        //去除action里面的-
        $action = $ruleItem->action;

        //把use-explain转成useExplain
        //把use-explain-vew转成useExplainView
        //把use留为use
        $actionArr = explode('-', $action);
        $actionList = [];
        foreach ($actionArr as $key => $actionStr) {
            $actionList[$key] = ucfirst($actionStr);
        }
        $action = implode('', $actionList);
        $action = lcfirst($action);

        //得出类来
        $model = ucfirst($ruleItem->model);
        $controller = ucfirst($ruleItem->controller);

        //类名
        $class = "\\app\\{$model}\\Controller\\{$controller}";

        try {
            $classObj = new $class;
            if (is_callable([$classObj, $action])) {
                //获取注解

                //获取当前操作方法的参数列表 如果有类就实例化一个

                $reflect = new \ReflectionMethod($classObj, $action);
                $dependencies = container()->resolveConstructor($reflect->getParameters());
                //$data = $reflect->invokeArgs($classObj, $dependencies);
                $data = self::execMethod($class, $classObj, $action, $dependencies);
            } else {
                throw new \Exception('Not find the function[' . $action . '] or model[' . $class . ']');
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $data;
    }

    /**
     * 执行function 这里是为了内部的function提供一个执行窗口，用来做注解功能，
     * 比如原来是$user->getUser(),现在改成App::execMethod(User::class,$user,'getUser');
     * @param $class 类名
     * @param $instance 类实例
     * @param $method 方法名
     * @param array $args 参数列表
     * @return
     * @throws \Exception
     */
    public static function execMethod($class, $instance, $method, $args)
    {
        $startTime = microtime(true);
        //$data = $instance->$method(...$args);
        $data = call_user_func_array(array($instance, $method), $args);
        $runTime = microtime(true) - $startTime;   //计算运行时间

        //获取注解
        $clsAnnotations = new Annotations();
        $clsAnnotations->setClass($class);
        $clsAnnotations->setMethod($method);
        $annotationsList = $clsAnnotations->getMethodParameters();

        //处理注解
        $clsDcrAnnotations = new \dcr\Annotations();
        $clsDcrAnnotations->setAnnotations($clsAnnotations);
        $clsDcrAnnotations->setReturnData($data);
        $clsDcrAnnotations->setAnnotationsList($annotationsList);
        $clsDcrAnnotations->setRunTime($runTime);
        $clsDcrAnnotations->exec();
        return $data;
    }
}
