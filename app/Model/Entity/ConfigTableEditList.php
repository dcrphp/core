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
    private $keyword;

    /**
     * @var string
     *
     * @ORM\Column(name="page_title", type="string", length=45, nullable=false)
     */
    private $pageTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="page_model", type="string", length=45, nullable=false)
     */
    private $pageModel;

    /**
     * @var string
     *
     * @ORM\Column(name="table_name", type="string", length=45, nullable=false)
     */
    private $tableName;

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
    private $listOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="list_where", type="string", length=45, nullable=false)
     */
    private $listWhere;

    /**
     * @var string
     *
     * @ORM\Column(name="edit_window_width", type="string", length=45, nullable=false)
     */
    private $editWindowWidth;

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
}
