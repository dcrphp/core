[![Build Status](https://travis-ci.org/junqing124/dcrphp.svg?branch=master)](https://travis-ci.org/junqing124/dcrphp) 
[![Coverage Status](https://coveralls.io/repos/github/junqing124/dcrphp/badge.svg?branch=master)](https://coveralls.io/github/junqing124/dcrphp?branch=master) 
[![Latest Stable Version](https://poser.pugx.org/junqing124/dcrphp/v/stable.png)](https://packagist.org/packages/junqing124/dcrphp) 
[![Latest Unstable Version](https://poser.pugx.org/junqing124/dcrphp/v/unstable.png)](https://packagist.org/packages/junqing124/dcrphp)  

dcrphp致力于应用层用户使用简单，后端用户开发简单。本系统采用前后端分离开发，自己开发的框架，自带扩展性强的模型管理及后台管理系统。可以很方便在上面自由的扩展。特点如下:  
&nbsp;&nbsp;1、自带后台管理及基本的RABC及扩展性强的模型方案 
&nbsp;&nbsp;2、MVC模式  
&nbsp;&nbsp;3、自动化的测试及编码检测  
  
安装源码(下面3选1)：  

    1、composer create-project junqing124/dcrphp dcrphp 1.0.1
    2、进入根目录执行:
        composer require junqing124/dcrphp  1.0.1  
        把vender/junqing124/dcrphp/下的内容剪切到根目录  
    3、源码安装:
        https://github.com/junqing124/dcrphp/tags 下载需要的版本，解压后:  
        composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/  
        composer install --no-dev -vvv  
        
 
下载好源码后，进入根目录安装系统:  

    安装路径是:host/install    
    安装完成后，后台地址是:host/admin 初始化用户名和密码是admin 123456  
  
附：nginx配置:  
charset utf-8;  
location / {  
&#8195;&#8195;try_files $uri $uri/ /index.php?$query_string;    
}  

1.0.2(开发中):  
    1、完善RABC  
    2、完善测试程序  
    3、修改数据库规则及现有的数据库结构  
    4、新增插件中心  
    5、插件中心内置增加：生成表结构、数据库管理  
    6、简单的route生效，配置在config/route，key->value来简化route  
    7、安装web化  
    8、默认关闭debug模式  
    9、模板可配置  
    10、配置项可配置  

1.0.1(2020-03-15):  
    1、采用全新的底层框架，性能、开发效率提升  
    2、后台前后端方式开发，人性化提升  
    3、模板引擎使用twig，更健壮  
    4、采用模型方式，系统扩展性更强  

