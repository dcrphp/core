<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelField
 *
 * @ORM\Table(name="model_field", uniqueConstraints={@ORM\UniqueConstraint(name="udx_model_field_mlid_keyword", columns={"mf_ml_id", "mf_keyword"})})
 * @ORM\Entity
 */
class ModelField
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
     * @ORM\Column(name="mf_keyword", type="string", length=45, nullable=false)
     */
    private $mfKeyword = '';

    /**
     * @var string
     *
     * @ORM\Column(name="mf_value", type="string", length=200, nullable=false)
     */
    private $mfValue = '';

    /**
     * @var int
     *
     * @ORM\Column(name="mf_ml_id", type="integer", nullable=false)
     */
    private $mfMlId = '0';

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
     * @return ModelField
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
     * @return ModelField
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
     * @return ModelField
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
     * @return ModelField
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
     * @return ModelField
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
     * Set mfKeyword.
     *
     * @param string $mfKeyword
     *
     * @return ModelField
     */
    public function setMfKeyword($mfKeyword)
    {
        $this->mfKeyword = $mfKeyword;

        return $this;
    }

    /**
     * Get mfKeyword.
     *
     * @return string
     */
    public function getMfKeyword()
    {
        return $this->mfKeyword;
    }

    /**
     * Set mfValue.
     *
     * @param string $mfValue
     *
     * @return ModelField
     */
    public function setMfValue($mfValue)
    {
        $this->mfValue = $mfValue;

        return $this;
    }

    /**
     * Get mfValue.
     *
     * @return string
     */
    public function getMfValue()
    {
        return $this->mfValue;
    }

    /**
     * Set mfMlId.
     *
     * @param int $mfMlId
     *
     * @return ModelField
     */
    public function setMfMlId($mfMlId)
    {
        $this->mfMlId = $mfMlId;

        return $this;
    }

    /**
     * Get mfMlId.
     *
     * @return int
     */
    public function getMfMlId()
    {
        return $this->mfMlId;
    }
}
