<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelAddition
 *
 * @ORM\Table(name="model_addition")
 * @ORM\Entity
 */
class ModelAddition
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
     * @ORM\Column(name="ma_keyword", type="text", length=65535, nullable=false)
     */
    private $maKeyword;

    /**
     * @var string
     *
     * @ORM\Column(name="ma_description", type="text", length=65535, nullable=false)
     */
    private $maDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="ma_content", type="text", length=65535, nullable=false)
     */
    private $maContent;

    /**
     * @var int
     *
     * @ORM\Column(name="ma_ml_id", type="integer", nullable=false, options={"comment"="ml表主键"})
     */
    private $maMlId = '0';

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
     * @return ModelAddition
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
     * @return ModelAddition
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
     * @return ModelAddition
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
     * @return ModelAddition
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
     * @return ModelAddition
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
     * Set maKeyword.
     *
     * @param string $maKeyword
     *
     * @return ModelAddition
     */
    public function setMaKeyword($maKeyword)
    {
        $this->maKeyword = $maKeyword;

        return $this;
    }

    /**
     * Get maKeyword.
     *
     * @return string
     */
    public function getMaKeyword()
    {
        return $this->maKeyword;
    }

    /**
     * Set maDescription.
     *
     * @param string $maDescription
     *
     * @return ModelAddition
     */
    public function setMaDescription($maDescription)
    {
        $this->maDescription = $maDescription;

        return $this;
    }

    /**
     * Get maDescription.
     *
     * @return string
     */
    public function getMaDescription()
    {
        return $this->maDescription;
    }

    /**
     * Set maContent.
     *
     * @param string $maContent
     *
     * @return ModelAddition
     */
    public function setMaContent($maContent)
    {
        $this->maContent = $maContent;

        return $this;
    }

    /**
     * Get maContent.
     *
     * @return string
     */
    public function getMaContent()
    {
        return $this->maContent;
    }

    /**
     * Set maMlId.
     *
     * @param int $maMlId
     *
     * @return ModelAddition
     */
    public function setMaMlId($maMlId)
    {
        $this->maMlId = $maMlId;

        return $this;
    }

    /**
     * Get maMlId.
     *
     * @return int
     */
    public function getMaMlId()
    {
        return $this->maMlId;
    }
}
