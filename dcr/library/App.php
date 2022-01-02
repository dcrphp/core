<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 19:58
 */

namespace dcr;

use dcr\facade\Response;
use dcr\route\RuleItem;
use DcrPHP\Annotations\Annotations;
use DcrPHP\Cache\Cache;
use DcrPHP\Config\Config;
use DcrPHP\Container\Container;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class App
{

    /**
     * 是不是debug模式
     * @var int
     */
    public static $isDebug = false;

    /**
     * @return int
     */
    public static function getIsDebug(): int
    {
        return self::$isDebug;
    }

    /**
     * @param int $isDebug
     */
    public static function setIsDebug(int $isDebug)
    {
        self::$isDebug = $isDebug;
    }
    
    /**
     * @var $phpSapiName php运行模式
     */
    public static $phpSapiName;

    public static $runningModel; //运行模式 支持ajax web api cli

    /**
     * 自动加载类
     */
    public static function autoLoadClasses()
    {
        spl_autoload_register(array('\dcr\ClassLoader', 'loadClasses'), true, true);
    }


    /**
     * 初始化entity manager
     * @throws ORMException
     */
    public static function initEntityManager()
    {
        ENV::init();
        self::initConfig();
        $container = container();

        //orm加载
        //如果要加载事件，请:https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/events.html
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
            $container->instance(\Doctrine\ORM\EntityManager::class, $entityManager);
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
        /*$clsConfig->setDriver('php');//解析php格式的
        $clsConfig->init();*/
        $container->instance(\DcrPHP\Config\Config::class, $clsConfig);
        return $clsConfig;
    }

    /**
     * 检测运行模式
     */
    public static function setRunningModel()
    {
        self::$runningModel = 'web';
        if (\Whoops\Util\Misc::isAjaxRequest()) {
            self::$runningModel = 'ajax';
        }
        if (\Whoops\Util\Misc::isCommandLine()) {
            self::$runningModel = 'cli';
        }
        if ('/api/' == substr($_SERVER['REQUEST_URI'], 0, 5)) {
            self::$runningModel = 'api';
        }
    }

    /**
     * 加载基本配置
     */
    public static function initFromConfig()
    {
        // set default zt_id
        Session::_set('ztId', 1);

        //程序测试与否
        if (config('app.debug')) {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            @ini_set('display_errors', 'on');
        } else {
            @ini_set('display_errors', 'off');
        }
        //设置时区
        date_default_timezone_set(config('app.default_timezone'));
    }

    public static function initContainer()
    {
        $clsConfig = new Config(CONFIG_DIR);

        return Container::getInstance($clsConfig);
    }

    public static function init()
    {
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

        self::$phpSapiName = php_sapi_name();
        self::autoLoadClasses();

        self::setRunningModel();

        #初始化container
        $container = self::initContainer();

        Error::init();
        Env::init();

        $clsConfig = self::initConfig();

        //加载缓存
        if (env('CACHE_ENABLE')) {
            $clsCache = new Cache();
            $clsCache->setConfigFile(CONFIG_DIR . DS . 'cache.php');
            $clsCache->init();
            $container->instance($clsConfig->get('app.alias.cache'), $clsCache);
        }

        Session::init();

        self::initFromConfig();

        self::initEntityManager();

        //如果是命令行就直接返回
        $result = '';
        if ('cli' == self::$runningModel) {
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

    /**
     * 把use-explain转成useExplain
     * 把use-explain-vew转成useExplainView
     * 把use留为use
     * 上面的-可以用$explodeStr配置
     * @param $param
     * @param string $explodeStr
     */

    public static function formatParam($param, $explodeStr = '-')
    {
        $actionArr = explode($explodeStr, $param);
        $actionList = [];
        foreach ($actionArr as $key => $actionStr) {
            $actionList[$key] = ucfirst($actionStr);
        }
        $action = implode('', $actionList);
        $param = lcfirst($action);

        return $param;
    }

    public static function exec(RuleItem $ruleItem)
    {
        //去除action里面的-
        $action = $ruleItem->action;
        $action = self::formatParam($action);

        //得出类来
        $model = ucfirst($ruleItem->model);
        $controller = ucfirst($ruleItem->controller);

        //类名
        $class = "\\app\\{$model}\\Controller\\{$controller}";
        $classObj = new $class();

        if (is_callable([$classObj, $action])) {
            try {
                //获取注解

                //获取当前操作方法的参数列表 如果有类就实例化一个

                $reflect = new \ReflectionMethod($classObj, $action);
                $dependencies = container()->resolveConstructor($reflect->getParameters());
                //$data = $reflect->invokeArgs($classObj, $dependencies);
                return self::execMethod($class, $classObj, $action, $dependencies);
            } catch (\ReflectionException $e) {
                throw $e;
            } catch (\Exception $e) {
                throw $e;
            }
        } else {
            throw new \Exception('Not find the function[' . $action . '] or model[' . $class . ']');
        }
    }

    /**
     * 执行function 这里是为了内部的function提供一个执行窗口，用来做注解功能，
     * 比如原来是$user->getUser(),现在改成App::execMethod(User::class,$user,'getUser');
     * @param $class 类名
     * @param $instance 类实例
     * @param $method 方法名
     * @param array $args 参数列表
     * @return mixed
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
