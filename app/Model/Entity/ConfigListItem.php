<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigListItem
 *
 * @ORM\Table(name="config_list_item")
 * @ORM\Entity
 */
class ConfigListItem
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
     * @ORM\Column(name="form_text", type="string", length=45, nullable=false)
     */
    private $formText = '';

    /**
     * @var string
     *
     * @ORM\Column(name="data_type", type="string", length=10, nullable=false)
     */
    private $dataType = '';

    /**
     * @var string
     *
     * @ORM\Column(name="db_field_name", type="string", length=45, nullable=false)
     */
    private $dbFieldName = '';

    /**
     * @var int
     *
     * @ORM\Column(name="order_str", type="smallint", nullable=false, options={"default"="1"})
     */
    private $orderStr = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="default_str", type="string", length=45, nullable=false)
     */
    private $defaultStr = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_system", type="boolean", nullable=false)
     */
    private $isSystem = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="cl_id", type="integer", nullable=false)
     */
    private $clId = '0';



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
     * @return ConfigListItem
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
     * @return ConfigListItem
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
     * @return ConfigListItem
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
     * @return ConfigListItem
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
     * @return ConfigListItem
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
     * Set formText.
     *
     * @param string $formText
     *
     * @return ConfigListItem
     */
    public function setFormText($formText)
    {
        $this->formText = $formText;

        return $this;
    }

    /**
     * Get formText.
     *
     * @return string
     */
    public function getFormText()
    {
        return $this->formText;
    }

    /**
     * Set dataType.
     *
     * @param string $dataType
     *
     * @return ConfigListItem
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;

        return $this;
    }

    /**
     * Get dataType.
     *
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Set dbFieldName.
     *
     * @param string $dbFieldName
     *
     * @return ConfigListItem
     */
    public function setDbFieldName($dbFieldName)
    {
        $this->dbFieldName = $dbFieldName;

        return $this;
    }

    /**
     * Get dbFieldName.
     *
     * @return string
     */
    public function getDbFieldName()
    {
        return $this->dbFieldName;
    }

    /**
     * Set orderStr.
     *
     * @param int $orderStr
     *
     * @return ConfigListItem
     */
    public function setOrderStr($orderStr)
    {
        $this->orderStr = $orderStr;

        return $this;
    }

    /**
     * Get orderStr.
     *
     * @return int
     */
    public function getOrderStr()
    {
        return $this->orderStr;
    }

    /**
     * Set defaultStr.
     *
     * @param string $defaultStr
     *
     * @return ConfigListItem
     */
    public function setDefaultStr($defaultStr)
    {
        $this->defaultStr = $defaultStr;

        return $this;
    }

    /**
     * Get defaultStr.
     *
     * @return string
     */
    public function getDefaultStr()
    {
        return $this->defaultStr;
    }

    /**
     * Set isSystem.
     *
     * @param bool $isSystem
     *
     * @return ConfigListItem
     */
    public function setIsSystem($isSystem)
    {
        $this->isSystem = $isSystem;

        return $this;
    }

    /**
     * Get isSystem.
     *
     * @return bool
     */
    public function getIsSystem()
    {
        return $this->isSystem;
    }

    /**
     * Set clId.
     *
     * @param int $clId
     *
     * @return ConfigListItem
     */
    public function setClId($clId)
    {
        $this->clId = $clId;

        return $this;
    }

    /**
     * Get clId.
     *
     * @return int
     */
    public function getClId()
    {
        return $this->clId;
    }
}
