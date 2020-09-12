<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRoleConfig
 *
 * @ORM\Table(name="user_role_config", uniqueConstraints={@ORM\UniqueConstraint(name="uq_role_config_ru", columns={"u_id", "ur_id", "zt_id"})})
 * @ORM\Entity
 */
class UserRoleConfig
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_time", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $addTime = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updateTime = 'CURRENT_TIMESTAMP';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_approval", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isApproval = true;

    /**
     * @var int
     *
     * @ORM\Column(name="add_user_id", type="smallint", nullable=false, options={"default"="0"})
     */
    private $addUserId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="zt_id", type="smallint", nullable=false, options={"default"="1"})
     */
    private $ztId = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="u_id", type="integer", nullable=false, options={"default"="0", "comment"="用户ID"})
     */
    private $uId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="ur_id", type="integer", nullable=false, options={"default"="0", "comment"="角色id"})
     */
    private $urId = '0';
}
