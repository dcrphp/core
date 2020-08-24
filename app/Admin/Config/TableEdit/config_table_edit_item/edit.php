<?php

use app\Admin\Model\Common;

$supportDataType = Common::getFieldTypeList();
$supportDataType = array_column($supportDataType, 'key');
if (!in_array($dbInfo['data_type'], $supportDataType) && empty($dbInfo['default'])) {
    throw new \Exception('数据类型['. $dbInfo['data_type'] .']不在允许范围内，只允许' . implode(',', $supportDataType));
}

//如果type是radio或者checkbox或者select没有default则报错
if (in_array($dbInfo['data_type'], array('checkbox', 'radio', 'select')) && empty($dbInfo['default_str'])) {
    throw new \Exception('checkbox,radio,select类型的数据，请输入默认值');
}

//只有text类型才可以用双击列表页更新
if (!in_array($dbInfo['data_type'], array('text')) && $dbInfo['is_list_edit']) {
    throw new \Exception('text类型的数据，才能在列表页中双击编辑');
}
