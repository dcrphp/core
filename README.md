[![Build Status](https://travis-ci.org/dcrphp/core.svg?branch=master)](https://travis-ci.org/dcrphp/core) 
[![Coverage Status](https://coveralls.io/repos/github/dcrphp/core/badge.svg?branch=master)](https://coveralls.io/github/dcrphp/core?branch=master) 
[![Latest Stable Version](https://poser.pugx.org/dcrphp/core/v/stable.png)](https://packagist.org/packages/dcrphp/core) 
[![Latest Unstable Version](https://poser.pugx.org/dcrphp/core/v/unstable.png)](https://packagist.org/packages/dcrphp/core)  

dcrphp定位于低代码集群前后端分离的应用系统。应用层用户使用简单，后端用户开发简单。本系统采用前后端分离开发，后端自研框架，前端h-ui框架，开箱即用:  
　　1、RABC模型会员及权限管理  
　　2、高度可扩展的模组管理  
　　3、自由化高的自定义配置中心  
　　4、Table Edit任意表管理  
　　5、API中心集成文档及在线测试  
　　6、集成graylog日志集中管理   
  
php版本>=7.0，二次开发，请先看wiki里的开发者必读:https://github.com/dcrphp/core/wiki/开发者必读  

安装源码(下面4选1)：  

    1、composer create-project dcrphp/core dcrphp 1.0.4  
    2、进入根目录执行:
        composer require dcrphp/core  1.0.4  
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
    安装完成后，后台地址是:host/admin，使用配置好的用户名和密码登陆  
  
附： 
nginx配置:  
```charset utf-8;  
location / {  
    try_files $uri $uri/ /index.php?$query_string;    
}  
```

发版详细请看CHANGELOG.md