<?php


namespace app\Index\Model;

use app\Admin\Model\Admin;
use app\Admin\Model\User;
use dcr\App;
use dcr\ENV;
use dcr\facade\Db;
use Thamaraiselvam\MysqlImport\Import;

class Install
{
    private $sqlFilePath = ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'sql';

    /**
     * @return string
     */
    public function getSqlFilePath(): string
    {
        return $this->sqlFilePath;
    }

    /**
     * 执行某个目录下的sql文件
     * @param $sqlDirPath
     * @return bool
     * @throws
     */
    public function executeSqlFiles($sqlDirPath)
    {
        ENV::init();
        $host = env('MYSQL_HOST');
        $port = env('MYSQL_PORT');
        $username = env('MYSQL_USERNAME');
        $password = env('MYSQL_PASSWORD');
        $database = env('MYSQL_DATABASE');
        $sqlFileList = scandir($sqlDirPath);

        try {
            foreach ($sqlFileList as $sqlFile) {
                if (pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                    $sqlFilename = $sqlDirPath . DS . $sqlFile;
                    //echo '-';
                    new Import($sqlFilename, $username, $password, $database, $host . ':' . $port);
                }
            }
        } catch (\Exception $ex) {
            throw $ex;
        }

        return true;
    }

    public function importDemoData()
    {
        $install = new Install();
        $install->executeSqlFiles($this->sqlFilePath);
        return Admin::commonReturn(1);
    }

    public function getLockFile()
    {
        return ROOT_APP . DS . 'Index' . DS . 'Install' . DS . 'lock';
    }

    public function canInstall()
    {
        $lockPath = $this->getLockFile();
        return !file_exists($lockPath);
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

            $data['config']['DB_TYPE'] = 'pdo_mysql';
            $data['config']['MYSQL_DRIVER'] = 'mysql';
            $data['config']['MYSQL_HOST'] = $host;
            $data['config']['MYSQL_PORT'] = $port;
            $data['config']['MYSQL_DATABASE'] = $database;
            $data['config']['MYSQL_USERNAME'] = $username;
            $data['config']['MYSQL_PASSWORD'] = $password;
            $data['config']['MYSQL_CHARSET'] = $charset;
            Env::write($envFile, $data);

            App::initConfig();

            //dd(file_get_contents( $envFile ));

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

            //重新加载配置
            App::initEntityManager();

            $install = new Install();
            $install->executeSqlFiles($this->sqlFilePath);

            $sqlFileList = scandir($this->sqlFilePath);
            foreach ($sqlFileList as $sqlFile) {
                if (pathinfo($sqlFile, PATHINFO_EXTENSION) === 'sql') {
                    $tableNameArr = explode('_', pathinfo($sqlFile)['filename']);
                    unset($tableNameArr[0]);
                    $tableName = implode('_', $tableNameArr);
                    $truncateSql = "truncate table {$tableName}/*zt_id=0*/";
                    DB::exec($truncateSql);
                }
            }

            //添加role
            $info = array(
                'name' => '系统管理员',
                'note' => '系统最高权限',
                'zt_id' => session('ztId')
            );

            $clsUser = new \app\Model\User();
            $user = new User();
            $roleId = $user->addRole($info);

            //初始化user
            $userInfo = array(
                'username' => 'admin',
                'password' => '123456',
                'sex' => 1,
                'mobile' => '15718126135',
                'tel' => '',
                'is_super' => 1,
                'note' => '管理员',
                'zt_id' => 1,
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

            //登陆次数为0
            DB::update('user', array('zt_id' => 1, 'login_count' => 0), "id>0");

            $sqlDetail = <<<SQL
                INSERT INTO `config` VALUES (1,'2020-05-07 17:05:19','2020-06-20 06:38:32',1,1,1,'site_name','DcrPHP建站系统',1),(2,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'213123','12',1),(3,'2020-05-07 17:05:19','2020-06-23 11:19:22',1,1,1,'template_name','default',2);
                INSERT INTO `config_list` VALUES (1,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'基本配置',1,'config','base'),(2,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'模板配置',1,'config','template'),(3,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'新闻中心',0,'model','news'),(4,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'产品中心',0,'model','product'),(5,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'资料中心',0,'model','info');               
                INSERT INTO `config_list_item` VALUES (1,'2020-05-07 17:05:19','2020-06-24 09:21:29',1,1,1,'网站名','text','site_name',1,'',1,1),(4,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'模板名','select','template_name',1,'var.systemTemplateStr',1,2),(5,'2020-05-07 17:05:19','2020-06-24 09:21:29',1,1,1,'材质','text','material',1,'',0,4),(6,'2020-05-07 17:05:19','2020-06-24 09:21:29',1,1,1,'颜色','text','color',2,'',0,4),(7,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'产地','select','from',3,'江西,浙江',0,4);
                INSERT INTO `config_table_edit_item` VALUES (11,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'',0,1,'text','ID','id',2),(17,'2020-05-07 17:05:19','2020-06-25 11:17:39',1,1,1,'',0,1,0,'',1,'',0,0,'hidden','父表ID','ctel_id',2),(18,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'小写英文字母开头，只能小写英文及数字',1,'like',1,1,'text','字段名','db_field_name',2),(19,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'like',1,1,'text','标题','title',2),(20,'2020-05-07 17:05:19','2020-06-25 12:40:50',1,1,1,'string,text,select,radio,checkbox,hidden',0,1,0,'',1,'',0,1,'select','数据类型','data_type',2),(21,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','列表中显示','is_show_list',2),(22,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','列表中能搜索','is_search',2),(23,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','能添加','is_insert',2),(24,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,0,'checkbox','添加必填','is_insert_required',2),(25,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,0,'checkbox','能更新','is_update',2),(26,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,0,'checkbox','更新必填','is_update_required',2),(28,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'like,like_left,like_right,equal',0,1,0,'',1,'',0,0,'select','搜索类型','search_type',2),(29,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',1,'',0,0,'text','提示','tip',2),(30,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',1,'',0,0,'text','默认值','default_str',2),(33,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,0,0,'',0,'',0,1,'text','ID','id',1),(34,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',1,1,1,'',1,'',1,1,'text','关键字','keyword',1),(35,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',1,1,1,'',1,'like',1,1,'text','页面标题','page_title',1),(36,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',1,1,1,'',1,'like',1,1,'text','模块名','page_model',1),(37,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'like',0,0,'text','表名','table_name',1),(40,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','允许删除','is_del',1),(41,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','允许添加','is_add',1),(42,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'是',0,1,0,'',1,'',0,1,'checkbox','允许编辑','is_edit',1),(43,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'',0,0,'text','排序','list_order',1),(44,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'',0,0,'text','where','list_where',1),(45,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'添加或编辑弹出的窗口的宽以px或%结尾',0,'',0,0,'text','编辑窗口宽','edit_window_width',1),(46,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'添加或编辑弹出的窗口的高以px或%结尾	',0,'',0,0,'text','编辑窗口高','edit_window_height',1),(47,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'',0,'',0,0,'textarea','操作列自定义额外html','addition_option_html',1),(48,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_order=u_id,那么实际使用的list_order=list_order配置和get(',0,'',0,0,'text','允许使用外部变量','allow_config_from_request',1),(50,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'添加页面form额外的html',0,'',0,0,'textarea','添加页面form额外的html','add_page_addition_html',1),(51,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'编辑页面form额外的html',0,'',0,0,'textarea','编辑页面form额外的html','edit_page_addition_html',1),(52,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'列表里添加按钮拼接html(提交按钮前的添加的html)',0,'',0,0,'textarea','列表添加按钮拼接html','add_button_addition_html',1),(53,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'列表里编辑按钮拼接html(提交按钮前的添加的html)',0,'',0,0,'textarea','列表里编辑按钮拼接html','edit_button_addition_html',1),(57,'2020-05-07 17:05:19','2020-06-24 09:23:29',1,1,1,'',0,1,0,'列表按钮区额外html',1,'',0,0,'textarea','列表按钮区额外html','button_area_addition_html',1),(58,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,0,0,'0',0,'',0,1,'text','id','id',4),(59,'2020-05-28 09:30:18','2020-06-30 11:57:17',1,0,1,'',0,0,0,'0',0,'',0,1,'text','添加时间','add_time',4),(60,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,0,0,'0',0,'',0,0,'text','update_time','update_time',4),(61,'2020-05-28 09:30:18','2020-05-28 09:30:18',1,0,1,'',0,0,0,'0',0,'',0,0,'checkbox','is_approval','is_approval',4),(62,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,0,0,'0',0,'',0,0,'text','add_user_id','add_user_id',4),(63,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,0,0,'0',0,'',0,0,'text','zt_id','zt_id',4),(64,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,1,0,'',1,'like',1,1,'text','单行文本','string_input',4),(65,'2020-05-28 09:30:18','2020-06-24 09:23:29',1,0,1,'',0,1,0,'',1,'',0,1,'textarea','多行文本','text_input',4),(66,'2020-05-28 09:30:18','2020-05-28 09:38:35',1,0,1,'下拉1,下拉2',0,1,0,'',1,'',1,1,'select','下拉框','select',4),(67,'2020-05-28 09:30:18','2020-06-26 14:17:31',1,0,1,'单选1,单选2',0,1,0,'',1,'like',0,1,'radio','单选','radio',4),(68,'2020-05-28 09:30:18','2020-06-26 14:17:26',1,0,1,'多选1,多选2',0,1,0,'',1,'like',0,1,'checkbox','多选框','checkbox',4);
                INSERT INTO `config_table_edit_list` VALUES (1,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'config_table_edit_list','单表管理列表(勿删)','系统配置','config_table_edit_list',1,1,1,'id desc','','95%','95%','<a title=\"字段\" href=\"javascript:;\" onclick=\"open_iframe(\'配置字段\',\'/admin/tools/table-edit-list-view/config_table_edit_item?ctel_id={db.index_id}&list_where=ctel_id={db.index_id}\',\'95%\',\'95%\')\" class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont Hui-iconfont-menu\"></i></a>','','','','','','<a href=\"javascript:;\" onclick=\"open_iframe(\'自动生成\',\'/admin/tools/table-edit-generate-view\',\'600\',\'400\')\" class=\"btn btn-primary radius\"><i class=\"Hui-iconfont\"></i> 自动生成</a>'),(2,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,'config_table_edit_item','单表管理字段(勿删)','系统配置','config_table_edit_item',1,1,1,'id desc','','95%','95%','','list_where','<input type=\"hidden\" name=\"ctei_ctel_id\" value=\"{get.ctei_ctel_id}\">','','?ctei_ctel_id={get.ctei_ctel_id}','',''),(4,'2020-05-28 09:30:18','2020-06-24 06:49:39',1,1,1,'table_edit','TableEdit(案例)','系统配置','table_edit_example',1,1,1,'','','80%','60%','','','','','','','');/*zt_id*/
SQL;

            DB::exec($sqlDetail);

            if ($importDemo) {
                $install->importDemoData();
            }
            //记录已经安装
            $lockPath = $this->getLockFile();
            file_put_contents($lockPath, date('Y-m-d H:i:s'));

            return Admin::commonReturn(1);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
