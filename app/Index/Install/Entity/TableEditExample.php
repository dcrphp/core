<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TableEditExample
 *
 * @ORM\Table(name="table_edit_example")
 * @ORM\Entity
 */
class TableEditExample
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
     * @ORM\Column(name="string_input", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $stringInput = '';

    /**
     * @var string
     *
     * @ORM\Column(name="text_input", type="text", length=65535, nullable=false)
     */
    private $textInput;

    /**
     * @var string
     *
     * @ORM\Column(name="select", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $select = '';

    /**
     * @var string
     *
     * @ORM\Column(name="radio", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $radio = '';

    /**
     * @var string
     *
     * @ORM\Column(name="checkbox", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $checkbox = '';
}
