<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/4
 * Time: 0:49
 */
namespace Dcr;

/**
具体解析请看Route->addRuleFromRequest
 */
return array(
    'short' => array(
        'install' => 'index/index/install-view', #如果uri里path只是install替换成index/index/install-view
        'admin' => 'admin/index/index',
    ),
    'replace' => array(
        #'list' => 'index/index/list-view', #只要uri的path里有list都会替换成index/index/list-view 比如127.0.0.1/list/2访问的实际是:127.0.0.1/index/index/list-view/2
        #'about/my_info' => 'index/index/detail-view/7',
    )
);
