<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigList
 *
 * @ORM\Table(name="config_list", uniqueConstraints={@ORM\UniqueConstraint(name="uq_cl_name", columns={"name", "zt_id"})})
 * @ORM\Entity
 */
class ConfigList
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
     * @ORM\Column(name="name", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $name = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_system", type="boolean", nullable=false, options={"default"="0"})
     */
    private $isSystem = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=false, options={"default"="","comment"="类型 配置还是模型(config or model)"})
     */
    private $type = '';

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=45, nullable=false, options={"default"="","comment"="关键字，可以用来给列表做区别"})
     */
    private $keyword = '';
}
