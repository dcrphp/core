[![Build Status](https://travis-ci.org/dcrphp/core.svg?branch=master)](https://travis-ci.org/dcrphp/core) 
[![Coverage Status](https://coveralls.io/repos/github/dcrphp/core/badge.svg?branch=master)](https://coveralls.io/github/dcrphp/core?branch=master) 
[![Latest Stable Version](https://poser.pugx.org/dcrphp/core/v/stable.png)](https://packagist.org/packages/dcrphp/core) 
[![Latest Unstable Version](https://poser.pugx.org/dcrphp/core/v/unstable.png)](https://packagist.org/packages/dcrphp/core)  
  
DCRPHP是定位于低代码、集群、前后端分离的应用系统。  
1、php版本>=7.0  
2、数据库可用Mysql或Sqlite(可在安装页面增加数据库)  
3、二次开发请先看wiki:https://github.com/dcrphp/core/wiki/开发者必读    

安装源码(下面5选1)：  

    1、composer create-project dcrphp/core dcrphp  
    2、进入根目录执行:
        composer require dcrphp/core  
        把vender/dcrphp/core/下的内容剪切到根目录  
    3、源码安装:
        https://github.com/dcrphp/core/tags 下载需要的版本，解压后:  
        composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/  
        composer install --no-dev -vvv  
    4、www.dcrcms.com下载全量源码包  
       http://www.dcrcms.com/news.php?id=76  
    5、git clone最新的安装程序  
       git clone https://github.com/dcrphp/core.git  
       或  
       git clone https://gitee.com/dcrphp/core.git (不一定是最新版本)
       上面选一个地址下载好后进入目录执行composer install --no-dev -vvv
        
Web服务器配置根目录为:public  
安装系统如下:    

    安装路径是:host/install    
    安装完成后，后台地址是:host/admin，使用配置好的用户名和密码登陆  
  
附:  
1、nginx配置:  
```charset utf-8;  
location / {  
    try_files $uri $uri/ /index.php?$query_string;    
}  
```

2、apache配置:  
　　1、打开httpd.conf  
　　2、目录的:AllowOverride None改为AllowOverride All  
　　3、#LoadModule rewrite_module modules/mod_rewrite.so 前面的#去掉  
　　4、重启apache
  
3、php内置服务器:  
php -S 127.0.0.1:8888 -t public/  

更新日志请看CHANGELOG.md