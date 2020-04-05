<?php

namespace app\Console;

use app\Admin\Model\User;
use app\Model\Install;
use dcr\Env;
use dcr\Db;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thamaraiselvam\MysqlImport\Import;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\ArrayInput;

class AppInstall extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:install'); //注意这个是命令行
        $this->addArgument('host', InputArgument::REQUIRED, 'database host');
        $this->addArgument('port', InputArgument::REQUIRED, 'database host port');
        $this->addArgument('username', InputArgument::REQUIRED, 'database username');
        $this->addArgument('password', InputArgument::REQUIRED, 'database password');
        $this->addArgument('database', InputArgument::REQUIRED, 'database name');
        $this->addArgument('charset', InputArgument::REQUIRED, 'character set');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $envFileExample = ROOT_APP . DS . '..' . DS . 'env.example';
        $envFile = ROOT_APP . DS . '..' . DS . 'env';

        try {
            $io = new SymfonyStyle($input, $output);

            $io->title('Config start');
            //$output->writeln();
            $data = Env::getData($envFileExample);

            $host = $input->getArgument('host');
            $port = $input->getArgument('port');
            $username = $input->getArgument('username');
            $password = $input->getArgument('password');
            $database = $input->getArgument('database');
            $charset = $input->getArgument('charset');

            $data['config']['MYSQL_DB_HOST'] = $host;
            $data['config']['MYSQL_DB_PORT'] = $port;
            $data['config']['MYSQL_DB_DATABASE'] = $database;
            $data['config']['MYSQL_DB_USERNAME'] = $password;
            $data['config']['MYSQL_DB_PASSWORD'] = $username;
            $data['config']['MYSQL_DB_CHARSET'] = $charset;
            Env::write($envFile, $data);

            //重新加载配置
            Env::init();
            $container = container();
            $config = $container->make(\dcr\Config::class);
            $config->loadConfig();
            $container->instance(\dcr\Config::class, $config);

            //dd(file_get_contents( $envFile ));

            $io->title('Config success');
            $io->title('Sql import start');

            //用原始的创建
            $conn = mysqli_connect($host, $username, $password, '', $port);
            mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$database}` /*zt_id=1*/");

            $sqlFilePath = ROOT_APP . DS . 'Console' . DS . 'sql' . DS . 'install';
            $install = new Install();
            $install->executeSqlFiles($sqlFilePath);

            $io->title('Sql import end');
            $io->title('Initial start');

            $sqlFileList = scandir($sqlFilePath);
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
                'ur_name' => '系统管理员',
                'ur_note' => '系统最高权限',
                'zt_id' => session('ztId')
            );

            $user = new User();
            $roleId = $user->addRole($info);

            //初始化user
            $userInfo = array(
                'u_username' => 'admin',
                'u_password' => '123456',
                'u_sex' => 1,
                'u_mobile' => '15718126135',
                'u_tel' => '',
                'u_is_super' => 1,
                'u_note' => '管理员',
                'zt_id' => 1,
                'roles' => array(1),
            );
            //返回
            $type = 'add';
            $user->addEditUser($userInfo, $type);

            //权限权限配置
            $command = $this->getApplication()->find('permission:refresh');
            $arguments = [
                'command' => 'permission:refresh',
            ];
            $freshInput = new ArrayInput($arguments);
            $command->run($freshInput, $output);

            //给管理员配置全权限
            $permissionList = $user->getPermissionList();
            $permissionIds = implode(',', array_column($permissionList, 'up_id'));
            DB::update('zq_user_role', array('zt_id' => 1, 'ur_permissions' => $permissionIds,), "ur_name='系统管理员'");

            $io->title('Initial end');
            $io->title('Install success, you can login in by host/admin admin,123456');
        } catch (\Exception $e) {
            throw $e;
        }

        return 0;
    }
}
