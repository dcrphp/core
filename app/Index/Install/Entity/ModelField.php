<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelField
 *
 * @ORM\Table(name="model_field", uniqueConstraints={@ORM\UniqueConstraint(name="udx_model_field_mlid_keyword", columns={"mf_ml_id", "mf_keyword"})})
 * @ORM\Entity
 */
class ModelField
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
     * @ORM\Column(name="mf_keyword", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $mfKeyword = '';

    /**
     * @var string
     *
     * @ORM\Column(name="mf_value", type="string", length=200, nullable=false, options={"default"=""})
     */
    private $mfValue = '';

    /**
     * @var int
     *
     * @ORM\Column(name="mf_ml_id", type="integer", nullable=false, options={"default"="0"})
     */
    private $mfMlId = '0';

}
