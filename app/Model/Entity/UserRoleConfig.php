<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRoleConfig
 *
 * @ORM\Table(name="user_role_config", uniqueConstraints={@ORM\UniqueConstraint(name="uidx_ru", columns={"u_id", "ur_id", "zt_id"})})
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
     * @var int
     *
     * @ORM\Column(name="u_id", type="integer", nullable=false, options={"comment"="用户ID"})
     */
    private $uId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="ur_id", type="integer", nullable=false, options={"comment"="角色id"})
     */
    private $urId = '0';



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set addTime.
     *
     * @param \DateTime $addTime
     *
     * @return UserRoleConfig
     */
    public function setAddTime($addTime)
    {
        $this->addTime = $addTime;

        return $this;
    }

    /**
     * Get addTime.
     *
     * @return \DateTime
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * Set updateTime.
     *
     * @param \DateTime $updateTime
     *
     * @return UserRoleConfig
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime.
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set isApproval.
     *
     * @param bool $isApproval
     *
     * @return UserRoleConfig
     */
    public function setIsApproval($isApproval)
    {
        $this->isApproval = $isApproval;

        return $this;
    }

    /**
     * Get isApproval.
     *
     * @return bool
     */
    public function getIsApproval()
    {
        return $this->isApproval;
    }

    /**
     * Set addUserId.
     *
     * @param int $addUserId
     *
     * @return UserRoleConfig
     */
    public function setAddUserId($addUserId)
    {
        $this->addUserId = $addUserId;

        return $this;
    }

    /**
     * Get addUserId.
     *
     * @return int
     */
    public function getAddUserId()
    {
        return $this->addUserId;
    }

    /**
     * Set ztId.
     *
     * @param int $ztId
     *
     * @return UserRoleConfig
     */
    public function setZtId($ztId)
    {
        $this->ztId = $ztId;

        return $this;
    }

    /**
     * Get ztId.
     *
     * @return int
     */
    public function getZtId()
    {
        return $this->ztId;
    }

    /**
     * Set uId.
     *
     * @param int $uId
     *
     * @return UserRoleConfig
     */
    public function setUId($uId)
    {
        $this->uId = $uId;

        return $this;
    }

    /**
     * Get uId.
     *
     * @return int
     */
    public function getUId()
    {
        return $this->uId;
    }

    /**
     * Set urId.
     *
     * @param int $urId
     *
     * @return UserRoleConfig
     */
    public function setUrId($urId)
    {
        $this->urId = $urId;

        return $this;
    }

    /**
     * Get urId.
     *
     * @return int
     */
    public function getUrId()
    {
        return $this->urId;
    }
}
