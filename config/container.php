<?php

return array(
    # alias和auto_bind都是为了更好的找到类 auto_bind是

    //别名绑定 比如用config就可以获取\DcrPHP\Config\Config的实例
    'alias' => [
        'config' => \DcrPHP\Config\Config::class,
        'request' => dcr\Request::class,
        'rule' => dcr\route\Rule::class,
        'rule_item' => dcr\route\RuleItem::class,
        'route' => dcr\Route::class,
        'view' => dcr\View::class,
        'response' => dcr\facade\Response::class,
        'cache' => \DcrPHP\Cache\Cache::class,
        'em' => \Doctrine\ORM\EntityManager::class,
    ],

    //启动container时自动绑定好的类 可以用别名(如果用别名，请在alias里定义好) 也可以用类名
    'auto_bind' =>[
        'request', 'rule', 'rule_item', 'route', 'view', 'response', 'cache'
    ]
);
