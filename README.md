[![Build Status](https://travis-ci.org/dcrphp/core.svg?branch=master)](https://travis-ci.org/dcrphp/core) 
[![Coverage Status](https://coveralls.io/repos/github/dcrphp/core/badge.svg?branch=master)](https://coveralls.io/github/dcrphp/core?branch=master) 
[![Latest Stable Version](https://poser.pugx.org/dcrphp/core/v/stable.png)](https://packagist.org/packages/dcrphp/core) 
[![Latest Unstable Version](https://poser.pugx.org/dcrphp/core/v/unstable.png)](https://packagist.org/packages/dcrphp/core)  

dcrphp致力于应用层用户使用简单，后端用户开发简单的方向。本系统采用前后端分离开发，后端自研框架，前端h-ui框架，内置:  
　　1、自带后台管理  
　　2、会员RABC管理:集中授权管理  
　　3、模型管理:方便扩展任意模型来管理基本的关系表    
　　4、配置管理中心：集中配置管理  
　　5、任意表管理:可以通过简单配置，对任意表做增删改查  
  
dcrphp要求php版本>=7.0.0，如果想二开，请先看wiki里的开发者必读:https://github.com/dcrphp/core/wiki/开发者必读  

安装源码(下面4选1)：  

    1、composer create-project dcrphp/core dcrphp 1.0.3  
    2、进入根目录执行:
        composer require dcrphp/core  1.0.3  
        把vender/dcrphp/core/下的内容剪切到根目录  
    3、源码安装:
        https://github.com/dcrphp/core/tags 下载需要的版本，解压后:  
        composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/  
        composer install --no-dev -vvv  
    4、www.dcrcms.com下载全量源码包  
       http://www.dcrcms.com/news.php?id=76  
        
Web服务器配置根目录为public  
安装系统如下:    

    安装路径是:host/install    
    安装完成后，后台地址是:host/admin 初始化用户名和密码是admin 123456  
  
附： 
nginx配置:  
```charset utf-8;  
location / {  
    try_files $uri $uri/ /index.php?$query_string;    
}  
```

1.0.4(未知)  
　　1、代码组织三层分层  
　　2、缓存:dcrphp/cache  
　　3、注解中心  
　　4、配置:dcrphp/config  
　　5、table edit全新案例及修正bug  
　　6、日志:dcrphp/log   
　　7、集成用户日志和系统日志  
　　8、集成Doctrine ORM  
　　9、修正编辑器bug及ignore  
    
1.0.3(2020-05-12)  
　　1、部份文件重新组织  
　　2、后台JS统一化  
　　3、模型页面配置  
　　4、单表管理配置  
　　5、数据库规范制定  
　　6、Db类加上获取最后sql的功能，以方便数据库调试  
　　7、错误提示使用的是filp/whoops  

1.0.2(2020-04-17):  
　　1、完善RABC  
　　2、完善测试程序  
　　3、修改数据库规则及现有的数据库结构  
　　4、新增插件中心  
　　5、插件中心内置增加：生成表结构、数据库管理  
　　6、简单的route生效，配置在config/route，key->value来简化route  
　　7、安装web化  
　　8、默认关闭debug模式  
　　9、模板可配置  
　　10、配置中心可配置化  

1.0.1(2020-03-15):  
　　1、采用全新的底层框架，性能、开发效率提升  
　　2、后台前后端方式开发，人性化提升  
　　3、模板引擎使用twig，更健壮  
　　4、采用模型方式，系统扩展性更强  

