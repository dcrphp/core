<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/13
 * Time: 0:41
 */

namespace app\Index\Controller;

use app\Admin\Model\Factory;
use app\Admin\Model\Model;
use app\Index\Model\Install;
use app\Model\Config;
use dcr\facade\Db;
use dcr\Page;
use dcr\Request;

/**
 * Class Index
 * @package app\Index\Controller
 */
class Index
{

    public function viewCommon($view, $title, $position)
    {
        if (empty($title) || empty($position)) {
            throw new \Exception('请设置标题');
        }
        if (empty($position)) {
            throw new \Exception('请设置导航');
        }

        $clsConfig = new Config();
        $configTemplateName = $clsConfig->getSystemConfig('template_name');
        $view->setViewDirectoryPath(ROOT_PUBLIC . DS . 'resource' . DS . 'template' . DS . $configTemplateName . DS . 'view');
        $siteName = $clsConfig->getSystemConfig('site_name');

        $model = new Model();
        //分类
        $categoryNewsList = $model->getCategoryList('news', 0);
        $categoryProductList = $model->getCategoryList('product', 0);
        $view->assign('category_news', $categoryNewsList);
        $view->assign('category_product', $categoryProductList);
        $view->assign('site_name', $siteName);
        $view->assign('title', $title);
        $view->assign('position', $position);
    }

    public function detailView(Request $reqeust)
    {
        $model = new Model();
        $view = container('view');
        $paramInfo = $reqeust->getParams();
        $modelId = $paramInfo[0];
        DB::exec("update model_list set ml_view_nums=ml_view_nums+1 where zt_id=1 and id={$modelId}");
        $modelInfo = $model->getInfo(
            $modelId,
            array('requestField' => 1, 'requestAddition' => 1, 'requestFieldDec' => 1)
        );
        $clsConfig = new \app\Admin\Model\Config();
        $modelDefine = $clsConfig->getConfigList(0, 'model');
        $modelDefine = array_column($modelDefine, 'name', 'keyword');
        $modelCategoryName = $modelDefine[$modelInfo['list']['ml_model_name']];

        $categoryInfo = $model->getCategoryInfo($modelInfo['list']['ml_category_id']);
        $categoryName = $categoryInfo['name'];

        //得出field字段描述名
        $modelConfigList = $clsConfig->getConfigList(0, null, $modelInfo['list']['ml_model_name']);
        $clId = $modelConfigList[0]['id'];
        $modelFieldDecList = $clsConfig->getConfigListItemByListId($clId);
        $modelFieldDecList = array_column($modelFieldDecList, 'form_text', 'db_field_name');

        //dd($modelInfo);
        $this->viewCommon(
            $view,
            $modelInfo['list']['ml_title'],
            "<a href='/'>首页</a> / <a> {$modelCategoryName} </a> / <a href='/index/index/list-view/product/{$modelInfo['list']['ml_category_id']}'> {$categoryName} </a>"
        );
        $view->assign('info', $modelInfo);
        $view->assign('model_dec', $modelFieldDecList);

        return $view->render('detail');
    }

    public function listView(Request $request)
    {
        $model = new Model();
        $view = container('view');

        $paramInfo = $request->getParams();
        $modelName = $paramInfo[0];
        $categoryId = $paramInfo[1];

        $categoryInfo = $model->getCategoryInfo($categoryId);
        $view->assign('category_name', $categoryInfo['name']);

        $categoryDec = $modelName == 'product' ? '产品中心' : '新闻中心';
        $this->viewCommon(
            $view,
            $categoryInfo['name'] . ($modelName == 'product' ? '-产品中心' : '-新闻中心'),
            "<a href='/'>首页</a> / <a>{$categoryDec}</a> / <a>{$categoryInfo['name']}</a>'"
        );

        //总数量
        if ($categoryId) {
            $where[] = "ml_category_id={$categoryId}";
        }
        $pageInfo = $model->getList(array('where' => $where, 'col' => array('count(id) as num')));
        $pageTotalNum = $pageInfo[0]['num'];
        $page = get('page');
        $page = $page ? (int)$page : 1;
        $pageNum = 25;

        $pageTotal = ceil($pageTotalNum / $pageNum);
        $clsPage = new Page($page, $pageTotal);
        $pageHtml = $clsPage->showPage();

        $list = $model->getList(array(
            'where' => $where,
            'order' => 'id desc',
            'limit' => $pageNum,
            'offset' => ($page - 1) * $pageNum
        ));

        $view->assign('page', $page);
        $view->assign('nums', $pageTotalNum);
        $view->assign('list', $list);
        $view->assign('pages', $pageHtml);

        $templateFile = $modelName == 'product' ? 'product-list' : 'news-list';

        return $view->render($templateFile);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $view = container('view');
        $this->viewCommon($view, '首页', 'title');
        $model = new Model();

        //新闻
        $newsList = $model->getList(array(
            'limit' => 10,
            'col' => 'id,add_time,ml_title',
            'order' => 'id desc',
            'where' => "ml_model_name='news'"
        ));
        $view->assign('news_list', $newsList);
        //产品
        $categoryProductList = $model->getCategoryList('product', 0);
        $productCategoryList = array_column($categoryProductList, 'name', 'id');
        $index = 1;
        $productList = array();
        foreach ($productCategoryList as $categoryProductId => $categoryProductName) {
            $productList[$categoryProductId] = array();
            $productList[$categoryProductId]['index'] = $index++;
            $productList[$categoryProductId]['category_name'] = $categoryProductName;
            $productList[$categoryProductId]['sub'] = $model->getList(array(
                'limit' => 5,
                'col' => 'id,add_time,ml_title,ml_pic_path',
                'order' => 'id desc',
                'where' => "ml_model_name='product' and ml_category_id={$categoryProductId}"
            ));
        }
        //dd($productList);

        $view->assign('product_list', $productList);

        return $view->render('index');
    }

    public function installView()
    {
        /*$schema = new \Doctrine\DBAL\Schema\Schema();
        $myTable = $schema->createTable("my_table");
        $myTable->addColumn("id", "integer", array("unsigned" => true));
        $myTable->addColumn("username", "string", array("length" => 32));
        $myTable->setPrimaryKey(array("id"));
        $myTable->addUniqueIndex(array("username"));
        $myTable->setComment('Some comment');
        dd(Db::getConnection()->getDatabasePlatform());
        dd($schema->toSql(Db::getConnection()->getDatabasePlatform()));
        exit;*/
        $clsInstall = new Install();
        if (!$clsInstall->canInstall()) {
            throw new \Exception('已经安装过了，如果重新安装，请删除[' . realpath($clsInstall->getLockFile()) . ']再重新运行本安装程序');
        }
        $version = config('info.version');
        $assignData['version'] = $version;
        
        $view = container('view');
        $view->setViewDirectoryPath(ROOT_APP . DS . 'Index' . DS . 'View');
        $view->assign('admin_resource_url', env('ADMIN_RESOURCE_URL'));
        $view->assign('default_database_name', 'dcrphp-' . config('info.version'));
        $view->assign('sqlite_path', realpath(ROOT_PUBLIC) . DS . 'storage' . DS . 'sqlite.php');
        return $view->render('install');
    }

    public function installAjax()
    {
        try {
            $clsInstall = new Install();
            $clsInstall->setType(post('type'));
            $clsInstall->setAdminUsername(post('admin_user'));
            $clsInstall->setAdminPassword(post('admin_password'));
            $result = $clsInstall->install(
                'mysql' == post('type') ? post('host') : post('sqlite_path'),
                post('username'),
                post('password'),
                post('database'),
                post('port'),
                post('cover_data'),
                post('import_demo')
            );
            return Factory::renderJson($result, 1);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
