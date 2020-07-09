<?php
declare(strict_types=1);

namespace app\Model;

use app\Admin\Model\Admin;
use app\Model\Concerns\Model;
use app\Model\Entity\UserRoleConfig as NUserRoleConfig;
use dcr\facade\Db;
use dcr\Safe;
use Respect\Validation\Validator as v;

/**
 * Class User
 * @package app\Model
 */
class UserRoleConfig extends NUserRoleConfig implements Model
{
    /**
     * 验证数据
     * @PrePersist @PreUpdate
     * @param $entity
     * @throws \Exception
     */
    public function validate($entity)
    {
    }
}
