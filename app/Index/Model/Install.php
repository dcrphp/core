<?php

namespace app\Index\Model;

use app\Admin\Model\Admin;
use app\Admin\Model\User;
use app\Model\Config;
use app\Model\Entity;
use dcr\App;
use dcr\ENV;
use dcr\facade\Db;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class Install
{
    private $type = 'mysql'; //数据库类型
    private $useCaptcha = '是';
    private $sqlFilePath = ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'sql';
    private $adminUsername = 'admin'; //管理员用户名
    private $adminPassword = '123456'; //管理员密码

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getAdminUsername(): string
    {
        return $this->adminUsername;
    }

    /**
     * @param string $adminUsername
     */
    public function setAdminUsername(string $adminUsername)
    {
        $this->adminUsername = $adminUsername;
    }

    /**
     * @return string
     */
    public function getAdminPassword(): string
    {
        return $this->adminPassword;
    }

    /**
     * @param string $adminPassword
     */
    public function setAdminPassword(string $adminPassword)
    {
        $this->adminPassword = $adminPassword;
    }

    /**
     * @return string 是或否
     */
    public function getUseCaptcha(): string
    {
        return $this->useCaptcha;
    }

    /**
     * @param string $useCaptcha
     */
    public function setUseCaptcha(string $useCaptcha)
    {
        $this->useCaptcha = $useCaptcha;
    }

    /**
     * 获取锁定文件
     * @return string
     */
    public function getLockFile()
    {
        return ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'lock';
    }

    /**
     * 数据库类型
     * @throws \Exception
     */
    public function loadBaseConfig()
    {
        //把字段设置为not null和有default值

        $sqlDetail = <<<SQL
                INSERT INTO `config` VALUES (1,'2020-05-07 17:05:19','2020-06-20 06:38:32',1,1,1,'site_name','DcrPHP建站系统',1),(3,'2020-05-07 17:05:19','2020-06-23 11:19:22',1,1,1,'template_name','default',2),(4,'2020-05-07 17:05:19','2020-06-23 11:19:22',1,1,1,'use_captcha','是',1),(5,'2020-05-07 17:05:19','2020-06-23 11:19:22',1,1,1,'captcha_level',1,1),(6,'2020-05-07 17:05:19','2020-06-23 11:19:22',1,1,1,'api_token','',1);
                INSERT INTO `config_list` VALUES (1,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'基本配置',1,'config','base'),(2,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'模板配置',1,'config','template'),(3,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'新闻中心',0,'model','news'),(4,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'产品中心',0,'model','product'),(5,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'资料中心',0,'model','info');           
                INSERT INTO `config_list_item` VALUES (1,'2020-05-07 17:05:19','2020-06-24 09:21:29',1,1,1,'网站名','text','site_name',1,'',1,1),(4,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'模板名','select','template_name',1,'{"type":"var","name":"systemTemplateStr"}',1,2),(5,'2020-05-07 17:05:19','2020-06-24 09:21:29',1,1,1,'材质','text','material',1,'',0,4),(6,'2020-05-07 17:05:19','2020-06-24 09:21:29',1,1,1,'颜色','text','color',2,'',0,4),(7,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'产地','select','from',3,'江西,浙江',0,4),(8,'2020-07-14 03:39:58','2020-07-14 03:40:43',1,1,1,'开启登陆验证码','select','use_captcha',2,'是,否',0,1),(9,'2020-07-14 03:41:13','2020-07-14 03:41:13',1,1,1,'验证码难度','select','captcha_level',3,'1,2',0,1),(10,'2020-07-14 03:41:13','2020-07-14 03:41:13',1,1,1,'Api token','text','api_token',4,'1,2',0,1);
                INSERT INTO `config_table_edit_item` VALUES (11,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'',0,1,'text','ID','id',2,0),(17,'2020-05-07 17:05:19','2020-06-25 11:17:39',1,1,1,'',0,1,0,'',1,'',0,0,'hidden','父表ID','ctel_id',2,0),(18,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'小写英文字母开头，只能小写英文及数字',1,'like',1,1,'text','字段名','db_field_name',2,0),(19,'2020-05-07 17:05:19','2020-07-09 09:45:16',1,1,1,'',1,1,1,'',1,'like',1,1,'text','标题','title',2,0),(20,'2020-05-07 17:05:19','2020-07-09 09:51:09',1,1,1,'text,select,radio,checkbox,hidden',0,1,0,'',1,'',0,1,'select','数据类型','data_type',2,0),(21,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','列表中显示','is_show_list',2,0),(22,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','列表中能搜索','is_search',2,0),(23,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','能添加','is_insert',2,0),(24,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,0,'checkbox','添加必填','is_insert_required',2,0),(25,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,0,'checkbox','能更新','is_update',2,0),(26,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,0,'checkbox','更新必填','is_update_required',2,0),(28,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'like,like_left,like_right,equal',0,1,0,'',1,'',0,0,'select','搜索类型','search_type',2,0),(29,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',1,'',0,0,'text','提示','tip',2,0),(30,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'具体配置:https://github.com/dcrphp/core/wiki/说明:单表#默认值取值额外说明',1,'',0,0,'text','默认值','default_str',2,0),(33,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,0,0,'',0,'',0,1,'text','ID','id',1,0),(34,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',1,1,1,'',1,'',1,1,'text','关键字','keyword',1,0),(35,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',1,1,1,'',1,'like',1,1,'text','页面标题','page_title',1,1),(36,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',1,1,1,'',1,'like',1,1,'text','模块名','page_model',1,1),(37,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'like',0,0,'text','表名','table_name',1,0),(40,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','允许删除','is_del',1,0),(41,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','允许添加','is_add',1,0),(42,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','允许编辑','is_edit',1,0),(43,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'',0,0,'text','排序','list_order',1,0),(44,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'',0,0,'text','where','list_where',1,0),(45,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'添加或编辑弹出的窗口的宽以px或%结尾',0,'',0,0,'text','编辑窗口宽','edit_window_width',1,0),(46,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'添加或编辑弹出的窗口的高以px或%结尾	',0,'',0,0,'text','编辑窗口高','edit_window_height',1,0),(47,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_order=u_id,get("list_order")',0,'',0,0,'text','允许使用外部变量','allow_config_from_request',1,0),(48,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'',0,0,'textarea','列表页操作列额外html','addition_option_html',1,0),(50,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'添加页面form额外的html',0,'',0,0,'textarea','添加页面form额外的html','add_page_addition_html',1,0),(51,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'编辑页面form额外的html',0,'',0,0,'textarea','编辑页面form额外的html','edit_page_addition_html',1,0),(52,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'列表里添加按钮拼接html(提交按钮前的添加的html)',0,'',0,0,'textarea','列表添加按钮拼接html','add_button_addition_html',1,0),(53,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'列表里编辑按钮拼接html(提交按钮前的添加的html)',0,'',0,0,'textarea','列表里编辑按钮拼接html','edit_button_addition_html',1,0),(57,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'列表按钮区额外html',1,'',0,0,'textarea','列表按钮区额外html','button_area_addition_html',1,0),(58,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,0,0,'0',0,'',0,1,'text','id','id',3,0),(59,'2020-05-28 09:30:18','2020-06-30 11:57:17',1,0,1,'',0,0,0,'0',0,'',0,1,'text','添加时间','add_time',3,0),(60,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,0,0,'0',0,'',0,0,'text','update_time','update_time',3,0),(61,'2020-05-28 09:30:18','2020-05-28 09:30:18',1,0,1,'',0,0,0,'0',0,'',0,0,'checkbox','is_approval','is_approval',3,0),(62,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,0,0,'0',0,'',0,0,'text','add_user_id','add_user_id',3,0),(63,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,0,0,'0',0,'',0,0,'text','zt_id','zt_id',3,0),(64,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,1,0,'',1,'like',1,1,'text','单行文本','string_input',3,0),(65,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,1,0,'',1,'',0,1,'textarea','多行文本','text_input',3,0),(66,'2020-05-28 09:30:18','2020-05-28 09:38:35',1,0,1,'下拉1,下拉2',0,1,0,'',1,'',1,1,'select','下拉框','select',3,0),(67,'2020-05-28 09:30:18','2020-06-26 14:17:31',1,0,1,'单选1,单选2',0,1,0,'',1,'like',0,1,'radio','单选','radio',3,0),(68,'2020-05-28 09:30:18','2020-07-09 09:50:38',1,0,1,'多选1,多选2',0,1,0,'',1,'like',0,1,'checkbox','多选框','checkbox',3,0),(77,'2020-07-24 18:52:50','2020-07-24 18:52:50',1,0,1,'',0,0,0,'',0,'',0,1,'string','id','id',4,0),(78,'2020-07-24 18:52:50','2020-07-24 18:52:50',1,0,1,'',0,0,0,'',0,'',0,1,'string','add_time','add_time',4,0),(79,'2020-07-24 18:52:50','2020-07-24 18:52:50',1,0,1,'',0,0,0,'',0,'',0,0,'string','update_time','update_time',4,0),(80,'2020-07-24 18:52:50','2020-07-24 18:52:50',1,0,1,'',0,0,0,'',0,'',0,0,'checkbox','is_approval','is_approval',4,0),(81,'2020-07-24 18:52:50','2020-07-24 18:52:50',1,0,1,'',0,0,0,'',0,'',0,0,'string','add_user_id','add_user_id',4,0),(82,'2020-07-24 18:52:50','2020-07-24 18:52:50',1,0,1,'',0,0,0,'',0,'',0,0,'string','zt_id','zt_id',4,0),(83,'2020-07-24 18:52:50','2020-07-24 18:52:50',1,0,1,'',1,1,1,'',1,'like',1,1,'text','表名','table_name',4,1),(84,'2020-07-24 18:52:50','2020-07-24 18:52:50',1,0,1,'',1,1,1,'多字段用,分隔，全部请填*',1,'like',1,1,'text','字段名','field_name',4,1),(140,'2020-08-20 17:33:05','2020-08-20 17:33:05',1,1,1,'',0,0,0,'',0,'',0,0,'text','ID','id',5,0),(141,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'',0,0,'text','添加时间','add_time',5,0),(142,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'',0,0,'checkbox','','is_approval',5,0),(143,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'',0,0,'text','','add_user_id',5,0),(144,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'',0,0,'text','','zt_id',5,0),(145,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'like',1,1,'text','名称','name',5,0),(146,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'like',1,1,'text','进程id','process_id',5,0),(147,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'',0,1,'text','开始时间','time_start',5,0),(148,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'',0,1,'text','结束时间','time_end',5,0),(149,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'',0,1,'text','消耗时间','time_spend',5,0),(150,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'',0,0,0,'',0,'',0,1,'text','消息结果','msg',5,0),(151,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'执行中,执行成功,执行失败',0,0,0,'',0,'equal',1,1,'select','任务状态','status',5,0),(152,'2020-08-20 17:33:06','2020-08-20 17:33:06',1,1,1,'是',0,1,0,'允许在列表页中双击后能编辑字段',1,'',0,1,'checkbox','列表页双击编辑','is_list_edit',2,0);/*zt_id*/
                INSERT INTO `model_list` VALUES (5,'2020-05-07 10:46:33','2020-06-23 06:36:43',0,1,1,'关于我们','',8,'info',24),(6,'2020-05-07 10:46:33','2020-06-23 06:36:42',0,1,1,'联系我们','',8,'info',19);
                INSERT INTO `model_addition` VALUES (5,'2020-05-07 10:46:33','2020-05-07 10:46:33',0,1,1,'','','<p>dcrphp用于提供最基础的原生开发框架，主要目标让开发从最基础的编码中解放出来。</p><p><br/></p><p>dcrphp前身dcrcms,第一个版本于2010年发布，至2013年8月止，共计15个版本，期间数次升级底层及框架：</p><p><a target=\"_blank\" href=\"http://www.dcrcms.com/news.php?id=2\">http://www.dcrcms.com/news.php?id=2</a></p><p><a target=\"_blank\" href=\"http://www.dcrcms.com/news.php?id=2\">http://www.dcrcms.com/news.php?id=58</a></p><p><br/></p><p>本次发现全新版本命名为dcrphp，是用了全新的自主底层，自主的框架，定位不再是企业站范围，而是可以在此基础上快捷方便的开发其它业务型系统，用技术更好的服务大家。</p><p><br/></p>',5),(6,'2020-05-07 10:46:33','2020-05-07 10:46:33',0,1,1,'','','<p>欢迎使用dcrphp建立系统。</p><p>关于dcrphp的使用问题、改进建议，可以按如下方式之一联系我们。</p><p><br/></p><p>QQ:335759285</p><p>Email:junqing124@126.com</p>',6);
                INSERT INTO `model_category` VALUES (8,'2020-05-07 10:46:33','2020-05-07 10:46:33',0,1,1,'info','基础',0);
SQL;

        if ('sqlite' == $this->getType()) {
            $sqlDetail = str_replace("\\'", "\\''", $sqlDetail);
        }

        $listData = array(
            'ConfigTableEditList' => array(
                array(
                    'keyword' => 'config_table_edit_list',
                    'page_title' => '单表管理列表(勿删)',
                    'page_model' => '系统配置',
                    'table_name' => 'config_table_edit_list',
                    'is_del' => 1,
                    'is_add' => 1,
                    'is_edit' => 1,
                    'list_order' => 'id desc',
                    'list_where' => '',
                    'edit_window_width' => '95%',
                    'edit_window_height' => '95%',
                    'addition_option_html' => '<a title="字段" href="javascript:;" onclick="open_iframe(\'配置字段\',\'/admin/tools/table-edit-list-view/config_table_edit_item?ctel_id={db.index_id}&list_where=ctel_id={db.index_id}\',\'95%\',\'95%\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont Hui-iconfont-menu"></i></a> <a title="导出" href="javascript:;" onclick="open_iframe(\'导出\',\'/admin/tools/table-edit-export-view?ctel_id={db.index_id}\',\'95%\',\'95%\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont Hui-iconfont-daochu"></i></a>',
                    'allow_config_from_request' => '',
                    'add_page_addition_html' => '',
                    'edit_button_addition_html' => '',
                    'add_button_addition_html' => '',
                    'edit_page_addition_html' => '',
                    'button_area_addition_html' => '<a href="javascript:;" onclick="open_iframe(\'自动生成\',\'/admin/tools/table-edit-generate-view\',\'600\',\'400\')" class="btn btn-primary radius"><i class="Hui-iconfont  Hui-iconfont-menu"></i> 自动生成</a>',
                ),
                array(
                    'keyword' => 'config_table_edit_item',
                    'page_title' => '单表管理字段(勿删)',
                    'page_model' => '系统配置',
                    'table_name' => 'config_table_edit_item',
                    'is_del' => 1,
                    'is_add' => 1,
                    'is_edit' => 1,
                    'list_order' => 'id desc',
                    'list_where' => '',
                    'edit_window_width' => '95%',
                    'edit_window_height' => '95%',
                    'addition_option_html' => '',
                    'allow_config_from_request' => 'list_where',
                    'add_page_addition_html' => '<input type="hidden" name="ctel_id" value="{get.ctel_id}">',
                    'edit_button_addition_html' => '',
                    'add_button_addition_html' => '?ctel_id={get.ctel_id}',
                    'edit_page_addition_html' => '',
                    'button_area_addition_html' => '',
                ),
                array(
                    'keyword' => 'table_edit',
                    'page_title' => 'TableEdit(案例)',
                    'page_model' => '系统配置',
                    'table_name' => 'table_edit_example',
                    'is_del' => 1,
                    'is_add' => 1,
                    'is_edit' => 1,
                    'list_order' => '',
                    'list_where' => '',
                    'edit_window_width' => '80%',
                    'edit_window_height' => '60%',
                    'addition_option_html' => '',
                    'allow_config_from_request' => '',
                    'add_page_addition_html' => '',
                    'edit_button_addition_html' => '',
                    'add_button_addition_html' => '',
                    'edit_page_addition_html' => '',
                    'button_area_addition_html' => '',
                ),
                array(
                    'keyword' => 'api_permission',
                    'page_title' => 'API权限',
                    'page_model' => '系统工具',
                    'table_name' => 'api_permission',
                    'is_del' => 1,
                    'is_add' => 1,
                    'is_edit' => 1,
                    'list_order' => '',
                    'list_where' => '',
                    'edit_window_width' => '70%',
                    'edit_window_height' => '70%',
                    'addition_option_html' => '',
                    'allow_config_from_request' => '',
                    'add_page_addition_html' => '',
                    'edit_button_addition_html' => '',
                    'add_button_addition_html' => '',
                    'edit_page_addition_html' => '',
                    'button_area_addition_html' => '',
                ),
                array(
                    'keyword' => 'crontab',
                    'page_title' => '计划任务',
                    'page_model' => '单表中心',
                    'table_name' => 'crontab',
                    'is_del' => 1,
                    'is_add' => 0,
                    'is_edit' => 0,
                    'list_order' => '',
                    'list_where' => '',
                    'edit_window_width' => '70%',
                    'edit_window_height' => '70%',
                    'addition_option_html' => '',
                    'allow_config_from_request' => '',
                    'add_page_addition_html' => '',
                    'edit_button_addition_html' => '',
                    'add_button_addition_html' => '',
                    'edit_page_addition_html' => '',
                    'button_area_addition_html' => '',
                ),
            ),
        );

        foreach ($listData as $tableName => $list) {
            foreach ($list as $detail) {
                $className = "app\\Model\\Entity\\{$tableName}";
                $clsEntity = new $className();
                foreach ($detail as $key => $value) {
                    $key = APP::formatParam($key, '_');
                    $functionName = 'set' . ucfirst($key);
                    $clsEntity->$functionName($value);
                }
                $clsEntity = Entity::setCommonData($clsEntity);
                container('em')->persist($clsEntity);
                container('em')->flush();
            }
        }

        DB::exec($sqlDetail);
    }

    /**
     * 修正字段 比如mysql下update加上on update current_timestamp
     * @throws \Exception
     */
    public function fixField()
    {
        $em = $this->initEntityManager();
        $conn = $em->getConnection();
        $databaseInfo = $conn->getDatabasePlatform();
        $databaseName = $databaseInfo->getName();
        $databaseName = strtolower(substr($databaseName, 0, 5));
        if ('mysql' == $databaseName) {
            //mysql加上on update current timestamp sqlite不支持
            $tableList = DB::getTables();
            foreach ($tableList as $table) {
                $alertSql = "ALTER TABLE `{$table->getName()}` CHANGE COLUMN `update_time` `update_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;";
                DB::exec($alertSql);
            }
        }
    }

    /**
     * 是不是能安装
     * @return bool
     */
    public function canInstall()
    {
        $lockPath = $this->getLockFile();
        return !file_exists($lockPath);
    }

    /**
     * 初始化entity manager
     * @throws ORMException
     */
    public function initEntityManager()
    {
        $installEntityDir = ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'Entity';
        //orm加载
        $ormConfig = Setup::createAnnotationMetadataConfiguration(
            array($installEntityDir),
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
            return \Doctrine\ORM\EntityManager::create($dbConn, $ormConfig);
        } catch (ORMException $e) {
            throw $e;
        }
    }

    public function install(
        $host,
        $username,
        $password,
        $database,
        $port = 3306,
        $coverData = 1,
        $importDemo = 1,
        $charset = 'utf8'
    ) {

        if (!$this->canInstall()) {
            throw new \Exception('已经安装过了，如果重新安装，请删除[' . realpath($this->getLockFile()) . ']再重新运行本安装程序');
        }

        $envFileExample = ROOT_APP . DS . '..' . DS . 'env.example';
        $envFile = ROOT_APP . DS . '..' . DS . 'env';

        try {
            $data = Env::getData($envFileExample);

            switch ($this->getType()) {
                case 'mysql':
                    $data['config']['DB_TYPE'] = 'pdo_mysql';
                    $data['config']['MYSQL_DRIVER'] = 'mysql';
                    $data['config']['MYSQL_HOST'] = $host;
                    $data['config']['MYSQL_PORT'] = $port;
                    $data['config']['MYSQL_DATABASE'] = $database;
                    $data['config']['MYSQL_USERNAME'] = $username;
                    $data['config']['MYSQL_PASSWORD'] = $password;
                    $data['config']['MYSQL_CHARSET'] = $charset;
                    break;
                case 'sqlite':
                    $data['config']['DB_TYPE'] = 'pdo_sqlite';
                    $data['config']['SQLITE_DRIVER'] = 'sqlite';
                    $data['config']['SQLITE_PATH'] = $host;
                    break;
                default:
                    throw new \Exception('还没有实现这个数据库的安装,请修改app\Index\Model\Install.php->function install()');
                    break;
            }

            Env::write($envFile, $data);

            //如果storage不存在，则建立
            $storagePath = realpath(ROOT_PUBLIC) . DS . 'storage';
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
            }

            App::initConfig();

            //dd(file_get_contents( $envFile ));

            if ('mysql' == $this->getType()) {
                //用原始的创建
                $conn = mysqli_connect($host, $username, $password, '', $port);
                if (!$conn) {
                    throw new \Exception('连接数据库失败');
                }
                if ($coverData) {
                    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$database}` /*zt_id=1*/");
                } else {
                    mysqli_query($conn, "CREATE DATABASE `{$database}` /*zt_id=1*/");
                }
            }

            //重新加载配置
            App::initEntityManager();
            Db::beginTransaction();

            //开始建表
            //获取install entity manager
            $entityManager = $this->initEntityManager();
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
            $classes = $entityManager->getMetadataFactory()->getAllMetadata();
            $schemaTool->dropSchema($classes);
            $schemaTool->createSchema($classes);
            $this->fixField();

            //添加role
            $roleList = array(
                array(
                    'name' => '系统管理员',
                    'note' => '系统最高权限',
                    'zt_id' => session('ztId')
                ),
                array(
                    'name' => '文章编辑员',
                    'note' => '文章编辑',
                    'zt_id' => session('ztId')
                ),
            );

            $clsUser = new \app\Model\User();
            $user = new User();
            foreach ($roleList as $roleInfo) {
                $roleId = $user->addRole($roleInfo);
            }

            //初始化user
            $userInfo = array(
                'username' => $this->getAdminUsername(),
                'password' => $this->getAdminPassword(),
                'sex' => 1,
                'mobile' => '15718126135',
                'tel' => '',
                'is_super' => 1,
                'note' => '管理员',
                'zt_id' => 1,
                'login_ip' => getIp(),
                'login_time' => time(),
                'roles' => array(1),
            );
            //返回
            $type = 'add';
            $clsUser->addEditUser($userInfo, $type);

            //权限权限配置
            $user->permissionRefresh();

            //给管理员配置全权限
            $permissionList = $user->getPermissionList();
            $permissionIds = implode(',', array_column($permissionList, 'id'));
            DB::update('user_role', array('zt_id' => 1, 'permissions' => $permissionIds,), "name='系统管理员'");

            //给文章管理员配置上权限
            $permissionArtList = $user->getPermissionList(
                array('where' => "name in('/文章列表','/文章列表/分类列表','/文章列表/添加编辑')")
            );
            $permissionArtIds = implode(',', array_column($permissionArtList, 'id'));
            $clsRoleList = container('em')->getRepository('\app\Model\Entity\UserRole')->findBy(
                array('name' => '文章编辑员')
            );
            $clsUserRole = $clsRoleList[0];
            $clsUserRole->setPermissions($permissionArtIds);
            container('em')->flush();

            //加载基本配置
            $this->loadBaseConfig();

            //登陆次数为0
            DB::update('user', array('zt_id' => 1, 'login_count' => 0), "id>0");

            //设置验证码要不要验证码
            $clsConfig = new Config();
            $clsConfig->setSystemConfig('use_captcha', $this->getUseCaptcha(), 1);

            //记录已经安装
            $lockPath = $this->getLockFile();
            file_put_contents($lockPath, date('Y-m-d H:i:s'));

            Db::commit();

            return Admin::commonReturn(1);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 获取not null但没有默认值的字段
     */
    public function getDbNotNullEmptyDefault()
    {
        $tables = Db::getTables();
        $result = array();
        foreach ($tables as $table) {
            $columns = $table->getColumns();
            foreach ($columns as $column) {
                if (!$column->getNotNull()) {
                    continue;
                }
                if (in_array(strtolower($column->getName()), array('id'))) {
                    continue;
                }
                $type = trim(strtolower($column->getType()->getName()));
                if (in_array($type, array('text'))) {
                    continue;
                }
                $default = $column->getDefault();
                if (!isset($default)) {
                    $result[] = array(
                        'database' => $table->getName(),
                        'column' => $column,
                    );
                }
            }
        }
        return $result;
    }
}
