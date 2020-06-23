<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigListItem
 *
 * @ORM\Table(name="config_list_item")
 * @ORM\Entity
 */
class ConfigListItem
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
     * @ORM\Column(name="form_text", type="string", length=45, nullable=false)
     */
    private $formText = '';

    /**
     * @var string
     *
     * @ORM\Column(name="data_type", type="string", length=10, nullable=false)
     */
    private $dataType = '';

    /**
     * @var string
     *
     * @ORM\Column(name="db_field_name", type="string", length=45, nullable=false)
     */
    private $dbFieldName = '';

    /**
     * @var int
     *
     * @ORM\Column(name="order_str", type="smallint", nullable=false, options={"default"="1"})
     */
    private $orderStr = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="default_str", type="string", length=45, nullable=false)
     */
    private $defaultStr = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_system", type="boolean", nullable=false)
     */
    private $isSystem = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="cl_id", type="integer", nullable=false)
     */
    private $clId = '0';


}
