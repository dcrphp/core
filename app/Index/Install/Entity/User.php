<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="uq_user_uz", columns={"username", "zt_id"})})
 * @ORM\Entity
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $username = '';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $password = '';

    /**
     * @var int
     *
     * @ORM\Column(name="zt_id", type="smallint", nullable=false, options={"default"="1"})
     */
    private $ztId = '1';

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
     * @var string
     *
     * @ORM\Column(name="login_ip", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $loginIp = '';

    /**
     * @var int
     *
     * @ORM\Column(name="login_count", type="smallint", nullable=false, options={"default"="0"})
     */
    private $loginCount = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="login_time", type="integer", nullable=false, options={"default"="0"})
     */
    private $loginTime = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_valid", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isValid = true;

    /**
     * @var int
     *
     * @ORM\Column(name="sex", type="smallint", nullable=false, options={"default"="0"})
     */
    private $sex = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $mobile = '';

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $tel = '';

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=100, nullable=false, options={"default"=""})
     */
    private $note = '';

    /**
     * @var int
     *
     * @ORM\Column(name="add_user_id", type="smallint", nullable=false, options={"default"="0"})
     */
    private $addUserId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="edit_user_id", type="smallint", nullable=false, options={"default"="0"})
     */
    private $editUserId = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_super", type="boolean", nullable=false, options={"default"="0", "comment"="是不是超级帐号"})
     */
    private $isSuper = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_approval", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isApproval = true;

}
