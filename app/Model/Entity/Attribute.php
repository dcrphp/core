<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attribute
 *
 * @ORM\Table(name="attribute", uniqueConstraints={@ORM\UniqueConstraint(name="udx_only", columns={"keyword", "data_id", "keyword_group"})})
 * @ORM\Entity
 */
class Attribute
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment"="ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_time", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP","comment"="添加时间"})
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
     * @ORM\Column(name="is_approval", type="boolean", nullable=false, options={"default"="1","comment"="审核状态"})
     */
    private $isApproval = true;

    /**
     * @var int
     *
     * @ORM\Column(name="add_user_id", type="smallint", nullable=false, options={"comment"="添加人ID"})
     */
    private $addUserId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="zt_id", type="smallint", nullable=false, options={"comment"="帐套ID"})
     */
    private $ztId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="keyword_group", type="string", length=50, nullable=false, options={"default"="''"})
     */
    private $keywordGroup = '\'\'';

    /**
     * @var int
     *
     * @ORM\Column(name="data_id", type="smallint", nullable=false)
     */
    private $dataId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=50, nullable=false, options={"default"="''"})
     */
    private $keyword = '\'\'';

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=300, nullable=false, options={"default"="''"})
     */
    private $value = '\'\'';



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
     * @return Attribute
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
     * @return Attribute
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
     * @return Attribute
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
     * @return Attribute
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
     * @return Attribute
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
     * Set keywordGroup.
     *
     * @param string $keywordGroup
     *
     * @return Attribute
     */
    public function setKeywordGroup($keywordGroup)
    {
        $this->keywordGroup = $keywordGroup;

        return $this;
    }

    /**
     * Get keywordGroup.
     *
     * @return string
     */
    public function getKeywordGroup()
    {
        return $this->keywordGroup;
    }

    /**
     * Set dataId.
     *
     * @param int $dataId
     *
     * @return Attribute
     */
    public function setDataId($dataId)
    {
        $this->dataId = $dataId;

        return $this;
    }

    /**
     * Get dataId.
     *
     * @return int
     */
    public function getDataId()
    {
        return $this->dataId;
    }

    /**
     * Set keyword.
     *
     * @param string $keyword
     *
     * @return Attribute
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword.
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set value.
     *
     * @param string $value
     *
     * @return Attribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
