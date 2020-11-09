<?php

declare(strict_types=1);

namespace app\Model\TraitClass;

use app\Admin\Model\Admin;
use app\Model\Entity;
use app\Model\Entity\ConfigAttributeItem;
use dcr\facade\Db;

trait ConfigAttribute
{
    public function getAttributeItemList($option = array())
    {
        $option['table'] = 'config_attribute_item';
        return Db::select($option);
    }
    public function updateAttributeItem($data)
    {
        Db::beginTransaction();
        $keywordGroup = $data['keyword_group'];
        $title = $data['title'];
        $keyword = $data['keyword'];
        $tips = $data['tips'];
        $isRequired = $data['is_required'];
        $version = time() . rand(1000, 9999);
        foreach ($keywordGroup as $key => $info) {
            $dbInfo = array();
            $dbInfo['keyword_group'] = $info;
            $dbInfo['title'] = $title[$key];
            $dbInfo['keyword'] = $keyword[$key];
            $dbInfo['tips'] = $tips[$key];
            $dbInfo['is_required'] = $isRequired[$key];

            if (!($dbInfo['title'] && $dbInfo['keyword'])) {
                continue;
            }

            //开始存数据
            $clsCA = container('em')->getRepository('\app\Model\Entity\ConfigAttributeItem')->findBy(
                array('keyword' => $dbInfo['keyword'], 'keywordGroup' => $dbInfo['keyword_group'])
            );
            $action = 'add';
            if ($clsCA) {
                $action = 'edit';
                $clsCA = $clsCA[0];
            } else {
                $clsCA = new ConfigAttributeItem();
            }

            $clsCA->setVersion($version);
            $clsCA->setKeywordGroup($dbInfo['keyword_group']);
            $clsCA->setTitle($dbInfo['title']);
            $clsCA->setKeyword($dbInfo['keyword']);
            $clsCA->setTips($dbInfo['tips']);
            $clsCA->setIsRequired($dbInfo['is_required']);

            if ('add' == $action) {
                $clsCA = Entity::setCommonData($clsCA);
                container('em')->persist($clsCA);
            } else {
                $clsCA = Entity::setCommonData($clsCA, 'updateTime');
            }
            container('em')->flush();
        }
        //删除不是这个版本号的
        Db::delete('config_attribute_item', "keyword_group='{$keywordGroup[0]}' and version!='{$version}'");

        Db::commit();
        return Admin::commonReturn(array('ack' => 1));
    }
}
