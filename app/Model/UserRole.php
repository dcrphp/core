<?php

declare(strict_types=1);

namespace app\Model;

use app\Admin\Model\Admin;
use app\Model\Concerns\Model;
use app\Model\Entity\UserRole as NUserRole;

/**
 * UserRole
 *
 * @ORM\Table(name="user_role")
 * @ORM\Entity
 */
class UserRole extends NUserRole implements Model
{
    public function validate($entity)
    {
        // TODO: Implement validate() method.
    }

    public function updateRolePermission($roleId, $newPermissionList)
    {
        $clsRoleConfig = container('em')->find('\app\Model\Entity\UserRole', $roleId);
        $clsRoleConfig->setPermissions(implode(',', $newPermissionList));
        $this->validate($clsRoleConfig);
        container('em')->flush();
        return Admin::commonReturn(array('ack' => 1));
    }
}
