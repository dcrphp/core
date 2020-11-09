<?php

namespace app\Index\Install\Entity;

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
    private $keywordGroup = '';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false, options={"default"="''"})
     */
    private $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=50, nullable=false, options={"default"="''"})
     */
    private $keyword = '';

    /**
     * @var string
     *
     * @ORM\Column(name="tips", type="string", length=100, nullable=false, options={"default"="''"})
     */
    private $tips = '';

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

}
