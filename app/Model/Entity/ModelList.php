<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelList
 *
 * @ORM\Table(name="model_list")
 * @ORM\Entity
 */
class ModelList
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
     * @ORM\Column(name="ml_title", type="string", length=150, nullable=false)
     */
    private $mlTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="ml_pic_path", type="string", length=150, nullable=false)
     */
    private $mlPicPath = '';

    /**
     * @var int
     *
     * @ORM\Column(name="ml_category_id", type="smallint", nullable=false)
     */
    private $mlCategoryId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ml_model_name", type="string", length=45, nullable=false)
     */
    private $mlModelName = '';

    /**
     * @var int
     *
     * @ORM\Column(name="ml_view_nums", type="integer", nullable=false, options={"comment"="浏览次数"})
     */
    private $mlViewNums = '0';



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
     * @return ModelList
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
     * @return ModelList
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
     * @return ModelList
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
     * @return ModelList
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
     * @return ModelList
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
     * Set mlTitle.
     *
     * @param string $mlTitle
     *
     * @return ModelList
     */
    public function setMlTitle($mlTitle)
    {
        $this->mlTitle = $mlTitle;

        return $this;
    }

    /**
     * Get mlTitle.
     *
     * @return string
     */
    public function getMlTitle()
    {
        return $this->mlTitle;
    }

    /**
     * Set mlPicPath.
     *
     * @param string $mlPicPath
     *
     * @return ModelList
     */
    public function setMlPicPath($mlPicPath)
    {
        $this->mlPicPath = $mlPicPath;

        return $this;
    }

    /**
     * Get mlPicPath.
     *
     * @return string
     */
    public function getMlPicPath()
    {
        return $this->mlPicPath;
    }

    /**
     * Set mlCategoryId.
     *
     * @param int $mlCategoryId
     *
     * @return ModelList
     */
    public function setMlCategoryId($mlCategoryId)
    {
        $this->mlCategoryId = $mlCategoryId;

        return $this;
    }

    /**
     * Get mlCategoryId.
     *
     * @return int
     */
    public function getMlCategoryId()
    {
        return $this->mlCategoryId;
    }

    /**
     * Set mlModelName.
     *
     * @param string $mlModelName
     *
     * @return ModelList
     */
    public function setMlModelName($mlModelName)
    {
        $this->mlModelName = $mlModelName;

        return $this;
    }

    /**
     * Get mlModelName.
     *
     * @return string
     */
    public function getMlModelName()
    {
        return $this->mlModelName;
    }

    /**
     * Set mlViewNums.
     *
     * @param int $mlViewNums
     *
     * @return ModelList
     */
    public function setMlViewNums($mlViewNums)
    {
        $this->mlViewNums = $mlViewNums;

        return $this;
    }

    /**
     * Get mlViewNums.
     *
     * @return int
     */
    public function getMlViewNums()
    {
        return $this->mlViewNums;
    }
}
