<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigTableEditList
 *
 * @ORM\Table(name="config_table_edit_list", uniqueConstraints={@ORM\UniqueConstraint(name="uidx_key", columns={"keyword"})})
 * @ORM\Entity
 */
class ConfigTableEditList
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
     * @ORM\Column(name="keyword", type="string", length=45, nullable=false)
     */
    private $keyword = '';

    /**
     * @var string
     *
     * @ORM\Column(name="page_title", type="string", length=45, nullable=false)
     */
    private $pageTitle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="page_model", type="string", length=45, nullable=false)
     */
    private $pageModel = '';

    /**
     * @var string
     *
     * @ORM\Column(name="table_name", type="string", length=45, nullable=false)
     */
    private $tableName = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_del", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isDel = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_add", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isAdd = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_edit", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isEdit = true;

    /**
     * @var string
     *
     * @ORM\Column(name="list_order", type="string", length=45, nullable=false)
     */
    private $listOrder = '';

    /**
     * @var string
     *
     * @ORM\Column(name="list_where", type="string", length=45, nullable=false)
     */
    private $listWhere = '';

    /**
     * @var string
     *
     * @ORM\Column(name="edit_window_width", type="string", length=45, nullable=false)
     */
    private $editWindowWidth = '';

    /**
     * @var string
     *
     * @ORM\Column(name="edit_window_height", type="string", length=45, nullable=false)
     */
    private $editWindowHeight = '';

    /**
     * @var string
     *
     * @ORM\Column(name="addition_option_html", type="string", length=2000, nullable=false, options={"comment"="操作里自定义操作html"})
     */
    private $additionOptionHtml = '';

    /**
     * @var string
     *
     * @ORM\Column(name="allow_config_from_request", type="string", length=2000, nullable=false, options={"comment"="请求里可以有的字段"})
     */
    private $allowConfigFromRequest = '';

    /**
     * @var string
     *
     * @ORM\Column(name="add_page_addition_html", type="string", length=2000, nullable=false, options={"comment"="添加页面form里额外的html"})
     */
    private $addPageAdditionHtml = '';

    /**
     * @var string
     *
     * @ORM\Column(name="edit_button_addition_html", type="string", length=2000, nullable=false, options={"comment"="列表里编辑按钮拼接html"})
     */
    private $editButtonAdditionHtml = '';

    /**
     * @var string
     *
     * @ORM\Column(name="add_button_addition_html", type="string", length=2000, nullable=false, options={"comment"="列表里添加按钮拼接html"})
     */
    private $addButtonAdditionHtml = '';

    /**
     * @var string
     *
     * @ORM\Column(name="edit_page_addition_html", type="string", length=2000, nullable=false, options={"comment"="编辑页面form里额外的html"})
     */
    private $editPageAdditionHtml = '';

    /**
     * @var string
     *
     * @ORM\Column(name="button_area_addition_html", type="string", length=2000, nullable=false, options={"comment"="列表按钮区额外html"})
     */
    private $buttonAreaAdditionHtml = '';



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
     * @return ConfigTableEditList
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
     * @return ConfigTableEditList
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
     * @return ConfigTableEditList
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
     * @return ConfigTableEditList
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
     * @return ConfigTableEditList
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
     * Set keyword.
     *
     * @param string $keyword
     *
     * @return ConfigTableEditList
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
     * Set pageTitle.
     *
     * @param string $pageTitle
     *
     * @return ConfigTableEditList
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle.
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set pageModel.
     *
     * @param string $pageModel
     *
     * @return ConfigTableEditList
     */
    public function setPageModel($pageModel)
    {
        $this->pageModel = $pageModel;

        return $this;
    }

    /**
     * Get pageModel.
     *
     * @return string
     */
    public function getPageModel()
    {
        return $this->pageModel;
    }

    /**
     * Set tableName.
     *
     * @param string $tableName
     *
     * @return ConfigTableEditList
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Get tableName.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Set isDel.
     *
     * @param bool $isDel
     *
     * @return ConfigTableEditList
     */
    public function setIsDel($isDel)
    {
        $this->isDel = $isDel;

        return $this;
    }

    /**
     * Get isDel.
     *
     * @return bool
     */
    public function getIsDel()
    {
        return $this->isDel;
    }

    /**
     * Set isAdd.
     *
     * @param bool $isAdd
     *
     * @return ConfigTableEditList
     */
    public function setIsAdd($isAdd)
    {
        $this->isAdd = $isAdd;

        return $this;
    }

    /**
     * Get isAdd.
     *
     * @return bool
     */
    public function getIsAdd()
    {
        return $this->isAdd;
    }

    /**
     * Set isEdit.
     *
     * @param bool $isEdit
     *
     * @return ConfigTableEditList
     */
    public function setIsEdit($isEdit)
    {
        $this->isEdit = $isEdit;

        return $this;
    }

    /**
     * Get isEdit.
     *
     * @return bool
     */
    public function getIsEdit()
    {
        return $this->isEdit;
    }

    /**
     * Set listOrder.
     *
     * @param string $listOrder
     *
     * @return ConfigTableEditList
     */
    public function setListOrder($listOrder)
    {
        $this->listOrder = $listOrder;

        return $this;
    }

    /**
     * Get listOrder.
     *
     * @return string
     */
    public function getListOrder()
    {
        return $this->listOrder;
    }

    /**
     * Set listWhere.
     *
     * @param string $listWhere
     *
     * @return ConfigTableEditList
     */
    public function setListWhere($listWhere)
    {
        $this->listWhere = $listWhere;

        return $this;
    }

    /**
     * Get listWhere.
     *
     * @return string
     */
    public function getListWhere()
    {
        return $this->listWhere;
    }

    /**
     * Set editWindowWidth.
     *
     * @param string $editWindowWidth
     *
     * @return ConfigTableEditList
     */
    public function setEditWindowWidth($editWindowWidth)
    {
        $this->editWindowWidth = $editWindowWidth;

        return $this;
    }

    /**
     * Get editWindowWidth.
     *
     * @return string
     */
    public function getEditWindowWidth()
    {
        return $this->editWindowWidth;
    }

    /**
     * Set editWindowHeight.
     *
     * @param string $editWindowHeight
     *
     * @return ConfigTableEditList
     */
    public function setEditWindowHeight($editWindowHeight)
    {
        $this->editWindowHeight = $editWindowHeight;

        return $this;
    }

    /**
     * Get editWindowHeight.
     *
     * @return string
     */
    public function getEditWindowHeight()
    {
        return $this->editWindowHeight;
    }

    /**
     * Set additionOptionHtml.
     *
     * @param string $additionOptionHtml
     *
     * @return ConfigTableEditList
     */
    public function setAdditionOptionHtml($additionOptionHtml)
    {
        $this->additionOptionHtml = $additionOptionHtml;

        return $this;
    }

    /**
     * Get additionOptionHtml.
     *
     * @return string
     */
    public function getAdditionOptionHtml()
    {
        return $this->additionOptionHtml;
    }

    /**
     * Set allowConfigFromRequest.
     *
     * @param string $allowConfigFromRequest
     *
     * @return ConfigTableEditList
     */
    public function setAllowConfigFromRequest($allowConfigFromRequest)
    {
        $this->allowConfigFromRequest = $allowConfigFromRequest;

        return $this;
    }

    /**
     * Get allowConfigFromRequest.
     *
     * @return string
     */
    public function getAllowConfigFromRequest()
    {
        return $this->allowConfigFromRequest;
    }

    /**
     * Set addPageAdditionHtml.
     *
     * @param string $addPageAdditionHtml
     *
     * @return ConfigTableEditList
     */
    public function setAddPageAdditionHtml($addPageAdditionHtml)
    {
        $this->addPageAdditionHtml = $addPageAdditionHtml;

        return $this;
    }

    /**
     * Get addPageAdditionHtml.
     *
     * @return string
     */
    public function getAddPageAdditionHtml()
    {
        return $this->addPageAdditionHtml;
    }

    /**
     * Set editButtonAdditionHtml.
     *
     * @param string $editButtonAdditionHtml
     *
     * @return ConfigTableEditList
     */
    public function setEditButtonAdditionHtml($editButtonAdditionHtml)
    {
        $this->editButtonAdditionHtml = $editButtonAdditionHtml;

        return $this;
    }

    /**
     * Get editButtonAdditionHtml.
     *
     * @return string
     */
    public function getEditButtonAdditionHtml()
    {
        return $this->editButtonAdditionHtml;
    }

    /**
     * Set addButtonAdditionHtml.
     *
     * @param string $addButtonAdditionHtml
     *
     * @return ConfigTableEditList
     */
    public function setAddButtonAdditionHtml($addButtonAdditionHtml)
    {
        $this->addButtonAdditionHtml = $addButtonAdditionHtml;

        return $this;
    }

    /**
     * Get addButtonAdditionHtml.
     *
     * @return string
     */
    public function getAddButtonAdditionHtml()
    {
        return $this->addButtonAdditionHtml;
    }

    /**
     * Set editPageAdditionHtml.
     *
     * @param string $editPageAdditionHtml
     *
     * @return ConfigTableEditList
     */
    public function setEditPageAdditionHtml($editPageAdditionHtml)
    {
        $this->editPageAdditionHtml = $editPageAdditionHtml;

        return $this;
    }

    /**
     * Get editPageAdditionHtml.
     *
     * @return string
     */
    public function getEditPageAdditionHtml()
    {
        return $this->editPageAdditionHtml;
    }

    /**
     * Set buttonAreaAdditionHtml.
     *
     * @param string $buttonAreaAdditionHtml
     *
     * @return ConfigTableEditList
     */
    public function setButtonAreaAdditionHtml($buttonAreaAdditionHtml)
    {
        $this->buttonAreaAdditionHtml = $buttonAreaAdditionHtml;

        return $this;
    }

    /**
     * Get buttonAreaAdditionHtml.
     *
     * @return string
     */
    public function getButtonAreaAdditionHtml()
    {
        return $this->buttonAreaAdditionHtml;
    }
}
