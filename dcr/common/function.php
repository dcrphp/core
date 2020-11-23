<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 22:25
 */

use dcr\Session;
use DcrPHP\Container\Container;

/**
 * 格式化输出变量 从1.0.7开始abandon 请用pr
 */
if (!function_exists('dump')) {
    function dump($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

/**
 * 格式化输出变量
 */
if (!function_exists('pr')) {
    function pr($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}
/**
 * 格式化输出变量 从1.0.7开始abandon 请用pr
 */
if (!function_exists('dd')) {
    /**
     * @param $var
     */
    function dd($var)
    {
        dump($var);
    }
}
/**
 * 格式化输出变量
 */
if (!function_exists('container')) {
    function container($abstract = '')
    {
        if (empty($abstract)) {
            return Container::getInstance();
        } else {
            return Container::getInstance()->get($abstract);
        }
    }
}
/**
 * 获取配置
 */
if (!function_exists('config')) {
    function config($name)
    {
        return Container::getInstance()->get('config')->get($name);
    }
}
/**
 * 获取配置
 */
if (!function_exists('env')) {
    function env($key, $default = '')
    {
        $value = getenv($key);
        if ('' === $value) {
            $value = $default;
        }
        return $value;
    }
}
/**
 * 获取post数据
 */
if (!function_exists('post')) {
    function post($name = '', $default = '')
    {
        return \container('request')->post($name, $default);
    }
}
/**
 * 获取get数据
 */
if (!function_exists('get')) {
    function get($name = '', $default = '')
    {
        return \container('request')->get($name, $default);
    }
}

/**
 * 获取session数据
 */
if (!function_exists('session')) {
    function session($name, $default = '')
    {
        return Session::_get($name, $default);
    }
}
if (!function_exists('getIp')) {
    function getIp()
    {
        if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif ($_SERVER['HTTP_CLIENT_IP']) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif ($_SERVER['REMOTE_ADDR']) {
            return $_SERVER['REMOTE_ADDR'];
        } elseif ($_SERVER['HTTP_X_FORWARDED']) {
            return $_SERVER['HTTP_X_FORWARDED'];
        } elseif ($_SERVER['HTTP_FORWARDED_FOR']) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif ($_SERVER['HTTP_FORWARDED']) {
            return $_SERVER['HTTP_FORWARDED'];
        } else {
            return 'UNKNOWN';
        }
    }

}

if (!function_exists('sqliteEscape')) {
    /**
     * 用于sqlite的转义
     * @param $key
     * @return string
     */
    function sqliteEscape($key)
    {
        $key = str_replace("/", "//", $key);
        $key = str_replace("'", "''", $key);
        return $key;
    }
}

if (!function_exists('cache')) {
    /**
     * @param mixed ...$args 一个参数表示获取 二个参数是设置 三个参数是设置加过期时间
     * @return string
     */
    function cache(...$args)
    {
        $clsCache = \container('cache');
        $result = '';
        switch (count($args)) {
            case 2:
                $result = $clsCache->save($args[0], $args[1], 0);
                break;
            case 3:
                if (-1 == $args[2]) {
                    $clsCache->delete($args[0]);
                } else {
                    $result = $clsCache->save($args[0], $args[1], $args[2]);
                }
                break;
            default:
                $result = $clsCache->fetch($args[0]);
                break;
        }
        return $result;
    }
}
