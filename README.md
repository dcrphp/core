[![Build Status](https://travis-ci.org/dcrphp/core.svg?branch=master)](https://travis-ci.org/dcrphp/core) 
[![Coverage Status](https://coveralls.io/repos/github/dcrphp/core/badge.svg?branch=master)](https://coveralls.io/github/dcrphp/core?branch=master) 
[![Latest Stable Version](https://poser.pugx.org/dcrphp/core/v/stable.png)](https://packagist.org/packages/dcrphp/core) 
[![Latest Unstable Version](https://poser.pugx.org/dcrphp/core/v/unstable.png)](https://packagist.org/packages/dcrphp/core)  
  
要求：1、php版本>=7.0 2、数据库可用Mysql或Sqlite(可自增数据库)。二次开发请先看wiki:https://github.com/dcrphp/core/wiki/开发者必读  

安装源码(下面5选1)：  

    1、composer create-project dcrphp/core dcrphp 1.0.5  
    2、进入根目录执行:
        composer require dcrphp/core  1.0.5  
        把vender/dcrphp/core/下的内容剪切到根目录  
    3、源码安装:
        https://github.com/dcrphp/core/tags 下载需要的版本，解压后:  
        composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/  
        composer install --no-dev -vvv  
    4、www.dcrcms.com下载全量源码包  
       http://www.dcrcms.com/news.php?id=76  
    5、git clone最新的安装程序  
       git clone https://github.com/dcrphp/core.git      
       上面选一个地址下载好后进入目录执行composer install --no-dev -vvv
        
Web服务器配置根目录为:public  
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

更新日志请看CHANGELOG.md