<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/8/10
 * Time: 18:26
 */

namespace dcr\route;

class Rule
{
    private $ruleList = [];
    public function addRuleItem(RuleItem $ruleItem)
    {
        array_push($this->ruleList, $ruleItem);
    }
}
