<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigTableEditItem
 *
 * @ORM\Table(name="config_table_edit_item", uniqueConstraints={@ORM\UniqueConstraint(name="uidx_db_ctel_id", columns={"db_field_name", "ctel_id"})})
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
     * @var bool
     *
     * @ORM\Column(name="is_input_hidden", type="boolean", nullable=false)
     */
    private $isInputHidden = '0';

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
}
