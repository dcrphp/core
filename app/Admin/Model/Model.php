<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/19
 * Time: 0:57
 */

namespace app\Admin\Model;

use dcr\facade\Db;
use Respect\Validation\Validator as v;

/**
 * model数据格式标准格式为:
 * array('list'=> array('list'=>array('model_list表内容'), 'field'=> array('model_field表内容'), 'addition'=> array('model_addition表内容'), 'other'=>array(其它信息))
 * Class Model
 * @package app\Admin\Model
 */
class Model
{

    /**
     * @param $modelId
     * @param array $option array('requestField'=>'是不是要附加filed表', 'requestAddition'=>'是不是要附加addition表', 'requestFieldDec'=>'是不是要加上Field的描述，这个数据从[配置中心->模型配置]里来')
     * @return mixed
     */
    public function getInfo($modelId, $option = array())
    {
        $join = array();
        if ($option['requestAddition']) {
            $join = array('table' => 'model_addition', 'type' => 'left', 'condition' => 'ma_ml_id=model_list.id');
        }

        //加上model_list.id as id的原因是为了避免多个id给污染后，groupModelInfo返回的other.id不对的问题
        $col = ($option['col'] ? $option['col'] : '*') . ',model_list.id as id';
        $info = DB::select(array(
            'table' => 'model_list',
            'col' => $col,
            'where' => "model_list.id={$modelId}",
            'join' => $join,
            'limit' => 1
        ));
        $info = current($info);
        //$info['ma_content'] = htmlentities($info['ma_content']);
        $info = $this->groupModelInfo($info);

        if ($option['requestField']) {
            $fieldList = DB::select(array(
                'table' => 'model_field',
                'where' => "mf_ml_id={$modelId}",
                'col' => 'mf_value,mf_keyword', //这里这么做是为了兼容编辑页里的field列表和加载配置
            ));
            $info['field'] = $fieldList;
        }
        //dd($info);
        //开始格式化
        return $info;
    }

    /**
     * @param array $option 同select的搜索
     * @return mixed
     */
    public function getList($option = array())
    {
        $join = array();
        if ($option['requestAddition']) {
            $join = array('table' => 'model_addition', 'type' => 'left', 'condition' => 'ma_ml_id=model_list.id');
        }
        if (count($join)) {
            $option['join'][] = $join;
        }
        $option['table'] = 'model_list';
        //echo DB::getLastSql();
        return DB::select($option);
    }

    /**
     * @param $categoryInfo
     * array('action'=>'add' 值为add或edit, 'model_name' => 'news', 'parent_id' => 0, 'category_name' => 'abc', 'id'=> 1 如果action为edit则这个id为必传 )
     * @return array
     */
    public function categoryEdit($categoryInfo)
    {
        //判断
        $error = array();
        $stringValidator = v::stringType()->length(1, 50);
        if (!$stringValidator->validate($categoryInfo['action'])) {
            $error[] = 'Action长度不符合[1-50]';
        }
        if ('edit' == $categoryInfo['action']) {
            if (!$stringValidator->validate($categoryInfo['id'])) {
                $error[] = '主ID[id]长度不符合[1-50]';
            }
        }
        if (!$stringValidator->validate($categoryInfo['model_name'])) {
            $error[] = '模型名长度不符合[1-50]';
        }
        if (!$stringValidator->validate($categoryInfo['category_name'])) {
            $error[] = '分类长度不符合[1-50]';
        }
        if ($error) {
            return Admin::commonReturn(0, $error);
            //return array('ack' => 0, 'msg' => $error);
        }
        //处理
        //dd($categoryInfo);
        $result = 0;
        $dbInfo = array(
            'model_name' => $categoryInfo['model_name'],
            'name' => $categoryInfo['category_name'],
            'parent_id' => $categoryInfo['parent_id'] ? $categoryInfo['parent_id'] : 0,
        );
        if ('add' == $categoryInfo['action']) {
            $dbInfo['add_user_id'] = session('userId');
            $dbInfo['zt_id'] = session('ztId');
            $result = DB::insert('model_category', $dbInfo);
        } else {
            //dd($categoryInfo);
            if ('edit' == $categoryInfo['action']) {
                $result = DB::update('model_category', $dbInfo, "id={$categoryInfo['id']}");
            }
        }

        return Admin::commonReturn($result);
    }

    public function getCategoryInfo($categoryId, $option = array())
    {
        $info = DB::select(array(
            'table' => 'model_category',
            'col' => $option['col'],
            'where' => "id={$categoryId}",
            'limit' => 1
        ));
        $info = current($info);
        return $info;
    }

    public function getCategoryList($modelName, $parentId = null, $option = array())
    {
        $ztId = session('ztId');
        if (!$option['col']) {
            $option['col'] = 'id,name,parent_id,model_name';
        }
        $whereArr = array();
        array_push($whereArr, "zt_id={$ztId} and model_name='{$modelName}'");
        if ($parentId !== null) {
            array_push($whereArr, "parent_id={$parentId}");
        }

        $list = DB::select(array('table' => 'model_category', 'col' => $option['col'], 'where' => $whereArr));

        return $list;
    }

    public function getCategoryTrHtml($modelName, $parentId = null)
    {

        $list = $this->getCategoryList($modelName, $parentId);
        $list = $this->getCategoryArr($list, $parentId ? $parentId : 0);
        $html = '';
        if ($list) {
            $html = $this->getCategoryTrDetailHtml($list);
        }
        return $html;
    }

    public function getCategoryTrDetailHtml($list)
    {
        static $optionHtml = '';
        foreach ($list as $info) {
            $optionHtml .= "<tr class='text-l'>
                <td>" . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $info['level']) . "{$info['name']}</td>
                <td class='td-manage'>
                    <a title=\"编辑\" href=\"javascript:;\" onclick=\"open_iframe('编辑','/admin/model/category-edit-view/{$info['model_name']}/edit/{$info['id']}','','300')\"
                       class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont\">&#xe6df;</i></a>";
            if (! count($info['sub']) > 0) {
                $optionHtml .= "<a title=\"删除\" href=\"javascript:;\" onclick=\"del({$info['id']})\" class=\"ml-5\"
                       style=\"text-decoration:none\"><i class=\"Hui-iconfont\">&#xe6e2;</i></a>";
            }
            $optionHtml .= "</td>
            </tr>";
            //dd($info['sub']);
            //var_dump(count($info['sub'])>0);
            if (count($info['sub']) > 0) {
                $this->getCategoryTrDetailHtml($info['sub']);
            }
        }
        return $optionHtml;
    }

    /**
     * 获取分类的select的html
     * @param $modelName
     * @param array $option 附加参数
     * array(
     *  'parentId'=> 父类ID
     *  'selectId'=> 选中的分类
     *  'subEnabled'=> 只让选最末级的分类
     *  'selectName'=> 这个select的名字
     * )
     * @return string
     */
    public function getCategorySelectHtml($modelName, $option = array())
    {
        //dd($parentId);
        //dd($option[selectId]);
        //echo $sql;
        //dd($list);
        $list = $this->getCategoryList($modelName, $option['parentId']);
        $list = $this->getCategoryArr($list, $option['parentId'] ? $option['parentId'] : 0);
        //dd($list);

        $option['selectName'] = $option['selectName'] ? $option['selectName'] : 'parent_id';
        $html = "<select name=\"{$option['selectName']}\" id='{$option['selectName']}' aria-required=\"true\" aria-invalid=\"false\">";
        $html .= "<option value=\"0\">一级分类</option>";
        //dd($list);
        if ($list) {
            $html .= $this->getCategorySelectOptionHtml($list, $option['selectId'], $option['subEnabled']);
        }
        //<option value=\"1\">新闻资讯</option>
        //<option value=\"11\">├行业动态</option>
        //<option value=\"12\">├行业资讯</option>
        //<option value=\"13\">├行业新闻</option>
        $html .= "</select>";
        return $html;
    }

    public function getCategorySelectOptionHtml($list, $selectId = null, $subEnabled = 0)
    {
        //dd(get_defined_vars());
        static $optionHtml = '';
        foreach ($list as $info) {
            $optionAdditionStr = '';
            //dd($selectId);
            //dd($info['id']);
            //echo '<hr>';
            if ($selectId == $info['id']) {
                $optionAdditionStr = ' selected ';
            }
            if (count($info['sub']) > 0 && $subEnabled) {
                $optionAdditionStr .= ' disabled ';
            }
            $txtAdd = '';
            if (0 != $info['level']) {
                $txtAdd = str_repeat('--', $info['level']) . '├';
            }
            $optionHtml .= "<option value='{$info['id']}' {$optionAdditionStr}>{$txtAdd}{$info['name']}</option>";
            //dd($info['sub']);
            //var_dump(count($info['sub'])>0);
            if (is_array($info['sub'])) {
                $this->getCategorySelectOptionHtml($info['sub'], $selectId, $subEnabled);
            }
        }
        return $optionHtml;
    }

    /**
     * 本function用来格式化从数据库中取来的数据
     * @param $list
     * @param $parentId
     * @param int $level
     * @return array
     */
    public function getCategoryArr($list, $parentId, $level = 0)
    {
        $tree = array();
        foreach ($list as $key => $value) {
            //dd($value);
            //echo $parentId;
            if ($value['parent_id'] == $parentId) {
                //echo 'a';
                $value['level'] = $level;
                $value['sub'] = $this->getCategoryArr($list, $value['id'], $level + 1);
                $tree[] = $value;
                unset($list[$key]);
            }
        }
        return $tree;
    }

    public function deleteCategory($id)
    {

        //验证
        $info = DB::select(array(
            'table' => 'model_category',
            'col' => 'id',
            'where' => "id={$id}",
            'limit' => 1
        ));
        $info = current($info);

        if (!$info) {
            return array('ack' => 0, 'msg' => '没有找到这个信息');
        }
        //逻辑
        $result = DB::delete('model_category', "id={$id}");
        //dd($dbPre->getSql());
        //返回

        return Admin::commonReturn($result);
    }

    /**
     * 返回表格前缀和数据结构的前缀对应关系
     * @return array
     */
    public function getInputTableKeyArr()
    {
        return array('list' => 'ml', 'field' => '', 'addition' => 'ma');
    }

    /**
     * 把传来的数据，按数据库来分组 比如list开头 则放到list组中，且key的list_换成 如果开头，则放到list组中
     * 比如list对应的是model_list表 field对应的是model_field addition对应的是model_addition
     * @param $info
     * @return array
     */
    public function groupModelInfo($info)
    {
        $arr = array();
        $arr['list'] = array();
        $arr['field'] = array();
        $arr['addition'] = array();
        //对应的新表的key
        $newKeyArr = $this->getInputTableKeyArr();
        $newKeyArrChange = array_flip($newKeyArr);
        foreach ($info as $key => $value) {
            $keyArr = explode('_', $key);
            //dd($keyArr);
            $tableKey = $keyArr[0];
            if (2 == strlen($tableKey)) {
                //是表的字段 表前缀是2位，这里用来格式化从数据库来的数据
                $newKey = $newKeyArrChange[$tableKey] ? $newKeyArrChange[$tableKey] : 'other';

                $arr[$newKey][$key] = $value;
            } else {
                unset($keyArr[0]);
                if (count($keyArr)) {
                    $newKey = ($newKeyArr[$tableKey] ? $newKeyArr[$tableKey] . '_' : '') . implode('_', $keyArr);
                } else {
                    $tableKey = 'other';
                    $newKey = $key;
                }
                //dd($tableKey);
                //dd($newKey);
                $arr[$tableKey][$newKey] = $value;
                $arr['other'][$key] = $value;
                //dd($arr);
                //exit;
            }
        }
        return $arr;
    }

    /**
     * 编辑资料，本function完全只是针对添加或修改资料里传来的数据
     */
    public function edit()
    {
        //分组
        $data = post();
        //内容
        $data['addition_content'] = $data['editorValue'];
        $info = $this->groupModelInfo($data);
        $id = $info['other']['id'];
        //判断
        $error = array();
        $stringValidator = v::stringType()->length(1, 5000);
        if (!$stringValidator->validate($info['list']['ml_title'])) {
            $error[] = '标题不能为空';
        }
        if (strlen($info['list']['ml_category_id'] < 1)) {
            $error[] = '分类不能为空';
        }
        if (strlen($info['addition']['ma_content']) < 1) {
            $error[] = '内容不能为空';
        }
        if ($error) {
            return Admin::commonReturn(0, $error);
        }
        if ('edit' == $data['action']) {
            //判断存在不存在
            $clsEntityModelList = container('em')->find('\app\Model\Entity\ModelList', $id);
            if (!$clsEntityModelList) {
                throw new \Exception('您要修改的模组id[' . $id . ']不存在');
            }
        }
        //逻辑

        //传图片
        $request = container('request');
        $fileUploadResult = array();
        $uploadDir = 'uploads' . DS . DS . date('Y-m-d');
        try {
            $fileUploadResult = $request->upload(
                'list_pic_path',
                $uploadDir,
                array('allowFile' => array('image/png', 'image/gif', 'image/jpg', 'image/jpeg'))
            );
            if (!$fileUploadResult['ack']) {
                return Admin::commonReturn(0, $fileUploadResult['msg']);
            }
        } catch (\Exception $e) {
            $fileUploadResult['ack'] = 0;
            $fileUploadResult['msg'] = $e->getMessage();
        }
        //dd($fileUploadResult);
        /*dd($fileUploadResult);
        exit;*/
        if ($fileUploadResult['ack']) {
            $info['list']['ml_pic_path'] = $uploadDir . DS . DS . $fileUploadResult['msg']['name'];
        }
        //如果没有更新图片则unset
        if (!strlen($info['list']['ml_pic_path'])) {
            unset($info['list']['ml_pic_path']);
        }
        //exit;
        //exit;

        $ztId = session('ztId');
        $userId = session('userId');
        $dbInfoList = $info['list'];
        $fieldList = $info['field'];
        $dbInfoAddition = $info['addition'];
        //dd($fieldList);

        $dbInfoList['zt_id'] = $ztId;

        //$dbInfoField['zt_id'] = $ztId;
        //$dbInfoField['me_update_time'] = time();

        $dbInfoAddition['zt_id'] = $ztId;
        if ('edit' == $data['action']) {
        } else {
            //$dbInfoField['me_add_time'] = time();
            $dbInfoList['add_user_id'] = $userId;
            //$dbInfoField['me_add_user_id'] = $userId;
            $dbInfoAddition['add_user_id'] = $userId;
        }
        //开始更新或添加
        $result = 1;
        DB::beginTransaction();
        if ('edit' == $data['action']) {
            //Log::systemLog(var_export($dbInfoList, true));
            $modelListSec = DB::update('model_list', $dbInfoList, "id={$id}");
            //Log::systemLog(DB::getLastSql());
            $modelAdditionSec = DB::update('model_addition', $dbInfoAddition, "ma_ml_id={$id}");
            $modelFieldError = 0;

            //dd($fieldList);
            foreach ($fieldList as $fieldKey => $fieldValue) {
                $fieldDbInfo = array();
                $fieldDbInfo['mf_keyword'] = $fieldKey;
                $fieldDbInfo['mf_value'] = is_array($fieldValue) ? implode(',', $fieldValue) : $fieldValue;

                $fieldInfo = DB::select(array(
                    'table' => 'model_field',
                    'col' => 'id',
                    'where' => "mf_keyword='{$fieldKey}' and mf_ml_id={$id}"
                ));
                if ($fieldInfo) {
                    $modelFieldSec = DB::update(
                        'model_field',
                        $fieldDbInfo,
                        "mf_keyword='{$fieldKey}' and mf_ml_id={$id}"
                    );
                } else {
                    $fieldDbInfo['mf_ml_id'] = $id;
                    $fieldDbInfo['zt_id'] = $ztId;
                    $fieldDbInfo['add_user_id'] = $userId;
                    $modelFieldSec = DB::insert('model_field', $fieldDbInfo);
                }

                if (0 == $modelFieldSec) {
                    $modelFieldError++;
                }
            }

            if ($modelListSec && $modelAdditionSec && !$modelFieldError) {
                DB::commit();
                $result = 1;
            } else {
                DB::rollBack();
                $result = 0;
            }
        } elseif ('add' == $data['action']) {
            //dd($dbInfoList);
            $modelListId = DB::insert('model_list', $dbInfoList);
            $dbInfoField['me_ml_id'] = $modelListId;
            $dbInfoAddition['ma_ml_id'] = $modelListId;
            //exit;

            //dd($dbInfoAddition);
            //dd($dbInfoAddition);
            $modelAdditionId = DB::insert('model_addition', $dbInfoAddition);

            $modelFieldError = 0;
            foreach ($fieldList as $fieldKey => $fieldValue) {
                $fieldDbInfo = array();
                $fieldDbInfo['mf_keyword'] = $fieldKey;
                $fieldDbInfo['mf_value'] = $fieldValue;
                $fieldDbInfo['mf_ml_id'] = $modelListId;
                $fieldDbInfo['zt_id'] = $ztId;
                $fieldDbInfo['add_user_id'] = $userId;

                $modelFieldId = DB::insert('model_field', $fieldDbInfo);
                if (0 == $modelFieldId) {
                    $modelFieldError++;
                }
            }

            //dd($modelListId);
            //dd($modelAdditionId);

            if ($modelAdditionId && $modelListId && !$modelFieldError) {
                DB::commit();
                $result = 1;
            } else {
                DB::rollBack();
                $result = 0;
            }
        }
        //exit;
        //返回
        return Admin::commonReturn($result);
    }

    /**
     * 1.0.4后开始作废 请用app/model/module->delete
     * @param $id
     * @return array|int[]
     * @throws \Exception
     */
    public function deleteAbandon($id)
    {
        //验证
        $info = DB::select(array('table' => 'model_list', 'col' => 'id', 'where' => "id={$id}", 'limit' => 1));
        $info = current($info);

        if (!$info) {
            return array('ack' => 0, 'msg' => '没有找到这个信息');
        }
        //逻辑
        $result = DB::delete('model_list', "id={$id}");

        //dd($dbPre->getSql());
        //返回

        return Admin::commonReturn($result);
    }
}
