<?php

namespace app\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelAddition
 *
 * @ORM\Table(name="model_addition")
 * @ORM\Entity
 */
class ModelAddition
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
     * @ORM\Column(name="ma_keyword", type="text", length=65535, nullable=false)
     */
    private $maKeyword;

    /**
     * @var string
     *
     * @ORM\Column(name="ma_description", type="text", length=65535, nullable=false)
     */
    private $maDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="ma_content", type="text", length=65535, nullable=false)
     */
    private $maContent;

    /**
     * @var int
     *
     * @ORM\Column(name="ma_ml_id", type="integer", nullable=false, options={"comment"="ml表主键"})
     */
    private $maMlId = '0';


}
