<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ApiPermission
 *
 * @ORM\Table(name="api_permission", uniqueConstraints={@ORM\UniqueConstraint(name="uq_api_permission_table_name", columns={"table_name"})})
 * @ORM\Entity
 */
class ApiPermission
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
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
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
     * @ORM\Column(name="table_name", type="string", length=20, nullable=false, options={"default"="","comment"="表名"})
     */
    private $tableName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="field_name", type="string", length=300, nullable=false, options={"default"="","comment"="多字段用,分隔，全部请填*"})
     */
    private $fieldName = '';
}
