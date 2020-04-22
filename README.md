[![Build Status](https://travis-ci.org/junqing124/dcrphp.svg?branch=master)](https://travis-ci.org/junqing124/dcrphp) 
[![Coverage Status](https://coveralls.io/repos/github/junqing124/dcrphp/badge.svg?branch=master)](https://coveralls.io/github/junqing124/dcrphp?branch=master) 
[![Latest Stable Version](https://poser.pugx.org/junqing124/dcrphp/v/stable.png)](https://packagist.org/packages/junqing124/dcrphp) 
[![Latest Unstable Version](https://poser.pugx.org/junqing124/dcrphp/v/unstable.png)](https://packagist.org/packages/junqing124/dcrphp)  

dcrphp致力于应用层用户使用简单，后端用户开发简单的方向。本系统采用前后端分离开发，后端自研框架，前端h-ui框架，另外开箱即用:  
&nbsp;&nbsp;1、自带后台管理
&nbsp;&nbsp;2、会员RABC管理   
&nbsp;&nbsp;3、扩展性强的模型管理，可以应对任何的模型管理  
&nbsp;&nbsp;4、自动化的测试及编码检测  
&nbsp;&nbsp;5、扩展性强的配置管理中心，可以定义自己的配置中心、配置字段  
&nbsp;&nbsp;6、扩展性强的数据表管理，可以通过简单配置，对任意表做增删改查  
  
dcrphp要求php版本>=7.0.0  
安装源码(下面4选1)：  

    1、composer create-project junqing124/dcrphp dcrphp 1.0.2
    2、进入根目录执行:
        composer require junqing124/dcrphp  1.0.2  
        把vender/junqing124/dcrphp/下的内容剪切到根目录  
    3、源码安装:
        https://github.com/junqing124/dcrphp/tags 下载需要的版本，解压后:  
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
charset utf-8;  
location / {  
&#8195;&#8195;try_files $uri $uri/ /index.php?$query_string;    
}  
1.0.3(未定)  
    1、只要简单配置，就可以对任意数据表做的增删改查  
    2、php开启严格模式  
    3、部份文件重新组织  

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

