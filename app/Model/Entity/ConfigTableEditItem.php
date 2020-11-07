<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigTableEditItem
 *
 * @ORM\Table(name="config_table_edit_item", uniqueConstraints={@ORM\UniqueConstraint(name="uq_ctei_db_ctel_id", columns={"db_field_name", "ctel_id"})})
 * @ORM\Entity
 */
class ConfigTableEditItem
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
     * @ORM\Column(name="default_str", type="string", length=200, nullable=false)
     */
    private $defaultStr = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_update_required", type="boolean", nullable=false)
     */
    private $isUpdateRequired = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_update", type="boolean", nullable=false)
     */
    private $isUpdate = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_insert_required", type="boolean", nullable=false)
     */
    private $isInsertRequired = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="tip", type="string", length=200, nullable=false)
     */
    private $tip = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_insert", type="boolean", nullable=false)
     */
    private $isInsert = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="search_type", type="string", length=10, nullable=false)
     */
    private $searchType = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_search", type="boolean", nullable=false)
     */
    private $isSearch = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_show_list", type="boolean", nullable=false)
     */
    private $isShowList = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="data_type", type="string", length=45, nullable=false)
     */
    private $dataType = '';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=false)
     */
    private $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="db_field_name", type="string", length=45, nullable=false)
     */
    private $dbFieldName = '';

    /**
     * @var int
     *
     * @ORM\Column(name="ctel_id", type="integer", nullable=false)
     */
    private $ctelId = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_list_edit", type="boolean", nullable=false, options={"comment"="列表页双击配置"})
     */
    private $isListEdit = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="list_show_type", type="string", length=10, nullable=false, options={"default"="文本"})
     */
    private $listShowType = '文本';

    /**
     * @var int
     *
     * @ORM\Column(name="list_show_image_height", type="smallint", nullable=false, options={"default"="50"})
     */
    private $listShowImageHeight = '50';

    /**
     * @var int
     *
     * @ORM\Column(name="list_show_image_width", type="smallint", nullable=false, options={"default"="50"})
     */
    private $listShowImageWidth = '50';

    /**
     * @var int
     *
     * @ORM\Column(name="list_show_index", type="smallint", nullable=false, options={"default"="10"})
     */
    private $listShowIndex = '10';



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
     * @return ConfigTableEditItem
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
     * @return ConfigTableEditItem
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
     * @return ConfigTableEditItem
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
     * @return ConfigTableEditItem
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
     * @return ConfigTableEditItem
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
     * Set defaultStr.
     *
     * @param string $defaultStr
     *
     * @return ConfigTableEditItem
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
     * Set isUpdateRequired.
     *
     * @param bool $isUpdateRequired
     *
     * @return ConfigTableEditItem
     */
    public function setIsUpdateRequired($isUpdateRequired)
    {
        $this->isUpdateRequired = $isUpdateRequired;

        return $this;
    }

    /**
     * Get isUpdateRequired.
     *
     * @return bool
     */
    public function getIsUpdateRequired()
    {
        return $this->isUpdateRequired;
    }

    /**
     * Set isUpdate.
     *
     * @param bool $isUpdate
     *
     * @return ConfigTableEditItem
     */
    public function setIsUpdate($isUpdate)
    {
        $this->isUpdate = $isUpdate;

        return $this;
    }

    /**
     * Get isUpdate.
     *
     * @return bool
     */
    public function getIsUpdate()
    {
        return $this->isUpdate;
    }

    /**
     * Set isInsertRequired.
     *
     * @param bool $isInsertRequired
     *
     * @return ConfigTableEditItem
     */
    public function setIsInsertRequired($isInsertRequired)
    {
        $this->isInsertRequired = $isInsertRequired;

        return $this;
    }

    /**
     * Get isInsertRequired.
     *
     * @return bool
     */
    public function getIsInsertRequired()
    {
        return $this->isInsertRequired;
    }

    /**
     * Set tip.
     *
     * @param string $tip
     *
     * @return ConfigTableEditItem
     */
    public function setTip($tip)
    {
        $this->tip = $tip;

        return $this;
    }

    /**
     * Get tip.
     *
     * @return string
     */
    public function getTip()
    {
        return $this->tip;
    }

    /**
     * Set isInsert.
     *
     * @param bool $isInsert
     *
     * @return ConfigTableEditItem
     */
    public function setIsInsert($isInsert)
    {
        $this->isInsert = $isInsert;

        return $this;
    }

    /**
     * Get isInsert.
     *
     * @return bool
     */
    public function getIsInsert()
    {
        return $this->isInsert;
    }

    /**
     * Set searchType.
     *
     * @param string $searchType
     *
     * @return ConfigTableEditItem
     */
    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;

        return $this;
    }

    /**
     * Get searchType.
     *
     * @return string
     */
    public function getSearchType()
    {
        return $this->searchType;
    }

    /**
     * Set isSearch.
     *
     * @param bool $isSearch
     *
     * @return ConfigTableEditItem
     */
    public function setIsSearch($isSearch)
    {
        $this->isSearch = $isSearch;

        return $this;
    }

    /**
     * Get isSearch.
     *
     * @return bool
     */
    public function getIsSearch()
    {
        return $this->isSearch;
    }

    /**
     * Set isShowList.
     *
     * @param bool $isShowList
     *
     * @return ConfigTableEditItem
     */
    public function setIsShowList($isShowList)
    {
        $this->isShowList = $isShowList;

        return $this;
    }

    /**
     * Get isShowList.
     *
     * @return bool
     */
    public function getIsShowList()
    {
        return $this->isShowList;
    }

    /**
     * Set dataType.
     *
     * @param string $dataType
     *
     * @return ConfigTableEditItem
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
     * Set title.
     *
     * @param string $title
     *
     * @return ConfigTableEditItem
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
     * Set dbFieldName.
     *
     * @param string $dbFieldName
     *
     * @return ConfigTableEditItem
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
     * Set ctelId.
     *
     * @param int $ctelId
     *
     * @return ConfigTableEditItem
     */
    public function setCtelId($ctelId)
    {
        $this->ctelId = $ctelId;

        return $this;
    }

    /**
     * Get ctelId.
     *
     * @return int
     */
    public function getCtelId()
    {
        return $this->ctelId;
    }

    /**
     * Set isListEdit.
     *
     * @param bool $isListEdit
     *
     * @return ConfigTableEditItem
     */
    public function setIsListEdit($isListEdit)
    {
        $this->isListEdit = $isListEdit;

        return $this;
    }

    /**
     * Get isListEdit.
     *
     * @return bool
     */
    public function getIsListEdit()
    {
        return $this->isListEdit;
    }

    /**
     * Set listShowType.
     *
     * @param string $listShowType
     *
     * @return ConfigTableEditItem
     */
    public function setListShowType($listShowType)
    {
        $this->listShowType = $listShowType;

        return $this;
    }

    /**
     * Get listShowType.
     *
     * @return string
     */
    public function getListShowType()
    {
        return $this->listShowType;
    }

    /**
     * Set listShowImageHeight.
     *
     * @param int $listShowImageHeight
     *
     * @return ConfigTableEditItem
     */
    public function setListShowImageHeight($listShowImageHeight)
    {
        $this->listShowImageHeight = $listShowImageHeight;

        return $this;
    }

    /**
     * Get listShowImageHeight.
     *
     * @return int
     */
    public function getListShowImageHeight()
    {
        return $this->listShowImageHeight;
    }

    /**
     * Set listShowImageWidth.
     *
     * @param int $listShowImageWidth
     *
     * @return ConfigTableEditItem
     */
    public function setListShowImageWidth($listShowImageWidth)
    {
        $this->listShowImageWidth = $listShowImageWidth;

        return $this;
    }

    /**
     * Get listShowImageWidth.
     *
     * @return int
     */
    public function getListShowImageWidth()
    {
        return $this->listShowImageWidth;
    }

    /**
     * Set listShowIndex.
     *
     * @param int $listShowIndex
     *
     * @return ConfigTableEditItem
     */
    public function setListShowIndex($listShowIndex)
    {
        $this->listShowIndex = $listShowIndex;

        return $this;
    }

    /**
     * Get listShowIndex.
     *
     * @return int
     */
    public function getListShowIndex()
    {
        return $this->listShowIndex;
    }
}
