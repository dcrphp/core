<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigAttributeItem
 *
 * @ORM\Table(name="config_attribute_item", uniqueConstraints={@ORM\UniqueConstraint(name="udx_only", columns={"keyword", "keyword_group"})})
 * @ORM\Entity
 */
class ConfigAttributeItem
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
     * @ORM\Column(name="keyword_group", type="string", length=20, nullable=false, options={"default"="''"})
     */
    private $keywordGroup = '\'\'';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false, options={"default"="''"})
     */
    private $title = '\'\'';

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=50, nullable=false, options={"default"="''"})
     */
    private $keyword = '\'\'';

    /**
     * @var string
     *
     * @ORM\Column(name="tips", type="string", length=100, nullable=false, options={"default"="''"})
     */
    private $tips = '\'\'';

    /**
     * @var int
     *
     * @ORM\Column(name="is_required", type="smallint", nullable=false)
     */
    private $isRequired = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=50, nullable=false)
     */
    private $version = '';



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
     * @return ConfigAttributeItem
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
     * @return ConfigAttributeItem
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
     * @return ConfigAttributeItem
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
     * @return ConfigAttributeItem
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
     * @return ConfigAttributeItem
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
     * @return ConfigAttributeItem
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
     * Set title.
     *
     * @param string $title
     *
     * @return ConfigAttributeItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set keyword.
     *
     * @param string $keyword
     *
     * @return ConfigAttributeItem
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
     * Set tips.
     *
     * @param string $tips
     *
     * @return ConfigAttributeItem
     */
    public function setTips($tips)
    {
        $this->tips = $tips;

        return $this;
    }

    /**
     * Get tips.
     *
     * @return string
     */
    public function getTips()
    {
        return $this->tips;
    }

    /**
     * Set isRequired.
     *
     * @param int $isRequired
     *
     * @return ConfigAttributeItem
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * Get isRequired.
     *
     * @return int
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * Set version.
     *
     * @param string $version
     *
     * @return ConfigAttributeItem
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}
