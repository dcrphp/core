<?php

namespace app\Index\Install\Entity;

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
     * @ORM\Column(name="add_user_id", type="smallint", nullable=false, options={"default"="0"})
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
     * @ORM\Column(name="default_str", type="string", length=200, nullable=false, options={"default"=""})
     */
    private $defaultStr = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_update_required", type="boolean", nullable=false, options={"default"="0"})
     */
    private $isUpdateRequired = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_update", type="boolean", nullable=false, options={"default"="0"})
     */
    private $isUpdate = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_insert_required", type="boolean", nullable=false, options={"default"="0"})
     */
    private $isInsertRequired = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="tip", type="string", length=200, nullable=false, options={"default"=""})
     */
    private $tip = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_insert", type="boolean", nullable=false, options={"default"="0"})
     */
    private $isInsert = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="search_type", type="string", length=10, nullable=false, options={"default"=""})
     */
    private $searchType = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_search", type="boolean", nullable=false, options={"default"="0"})
     */
    private $isSearch = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_show_list", type="boolean", nullable=false, options={"default"="0"})
     */
    private $isShowList = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="data_type", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $dataType = '';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="db_field_name", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $dbFieldName = '';

    /**
     * @var int
     *
     * @ORM\Column(name="ctel_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $ctelId = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_list_edit", type="boolean", nullable=false, options={"default"="0","comment"="列表页双击配置"})
     */
    private $isListEdit = '0';
}
