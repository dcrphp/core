<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plugins
 *
 * @ORM\Table(name="plugins", uniqueConstraints={@ORM\UniqueConstraint(name="uq_plugins_name", columns={"name"})})
 * @ORM\Entity
 */
class Plugins
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
     * @ORM\Column(name="update_time", type="datetime", nullable=false, columnDefinition="DATETIME on update CURRENT_TIMESTAMP"),  options={"default"="CURRENT_TIMESTAMP"})
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false, options={"default"=""})
     */
    private $description = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_valid", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isValid = true;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $author = '';

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $version = '';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $title = '';
}
