<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPermission
 *
 * @ORM\Table(name="user_permission", uniqueConstraints={@ORM\UniqueConstraint(name="uidx_name", columns={"name"})})
 * @ORM\Entity
 */
class UserPermission
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
     * @ORM\Column(name="add_user_id", type="smallint", nullable=false)
     */
    private $addUserId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="zt_id", type="smallint", nullable=false, options={"default"="1"})
     */
    private $ztId = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false, options={"comment"="权限名"})
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=13, nullable=false, options={"fixed"=true,"comment"="版本名"})
     */
    private $version = '';


}
