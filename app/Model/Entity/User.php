<?php

namespace app\Model\Entity;

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
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     */
    private $username = '';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=45, nullable=false)
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
     * @ORM\Column(name="login_ip", type="string", length=45, nullable=false)
     */
    private $loginIp = '';

    /**
     * @var int
     *
     * @ORM\Column(name="login_count", type="smallint", nullable=false)
     */
    private $loginCount = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="login_time", type="integer", nullable=false)
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
     * @ORM\Column(name="sex", type="smallint", nullable=false)
     */
    private $sex = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=45, nullable=false)
     */
    private $mobile = '';

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=45, nullable=false)
     */
    private $tel = '';

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=100, nullable=false)
     */
    private $note = '';

    /**
     * @var int
     *
     * @ORM\Column(name="add_user_id", type="smallint", nullable=false, options={"comment"="添加人id"})
     */
    private $addUserId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="edit_user_id", type="smallint", nullable=false)
     */
    private $editUserId = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_super", type="boolean", nullable=false, options={"comment"="是不是超级帐号"})
     */
    private $isSuper = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_approval", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isApproval = true;



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
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set ztId.
     *
     * @param int $ztId
     *
     * @return User
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
     * Set addTime.
     *
     * @param \DateTime $addTime
     *
     * @return User
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
     * @return User
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
     * Set loginIp.
     *
     * @param string $loginIp
     *
     * @return User
     */
    public function setLoginIp($loginIp)
    {
        $this->loginIp = $loginIp;

        return $this;
    }

    /**
     * Get loginIp.
     *
     * @return string
     */
    public function getLoginIp()
    {
        return $this->loginIp;
    }

    /**
     * Set loginCount.
     *
     * @param int $loginCount
     *
     * @return User
     */
    public function setLoginCount($loginCount)
    {
        $this->loginCount = $loginCount;

        return $this;
    }

    /**
     * Get loginCount.
     *
     * @return int
     */
    public function getLoginCount()
    {
        return $this->loginCount;
    }

    /**
     * Set loginTime.
     *
     * @param int $loginTime
     *
     * @return User
     */
    public function setLoginTime($loginTime)
    {
        $this->loginTime = $loginTime;

        return $this;
    }

    /**
     * Get loginTime.
     *
     * @return int
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }

    /**
     * Set isValid.
     *
     * @param bool $isValid
     *
     * @return User
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Get isValid.
     *
     * @return bool
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Set sex.
     *
     * @param int $sex
     *
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex.
     *
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set mobile.
     *
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile.
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set tel.
     *
     * @param string $tel
     *
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel.
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set note.
     *
     * @param string $note
     *
     * @return User
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set addUserId.
     *
     * @param int $addUserId
     *
     * @return User
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
     * Set editUserId.
     *
     * @param int $editUserId
     *
     * @return User
     */
    public function setEditUserId($editUserId)
    {
        $this->editUserId = $editUserId;

        return $this;
    }

    /**
     * Get editUserId.
     *
     * @return int
     */
    public function getEditUserId()
    {
        return $this->editUserId;
    }

    /**
     * Set isSuper.
     *
     * @param bool $isSuper
     *
     * @return User
     */
    public function setIsSuper($isSuper)
    {
        $this->isSuper = $isSuper;

        return $this;
    }

    /**
     * Get isSuper.
     *
     * @return bool
     */
    public function getIsSuper()
    {
        return $this->isSuper;
    }

    /**
     * Set isApproval.
     *
     * @param bool $isApproval
     *
     * @return User
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
}
