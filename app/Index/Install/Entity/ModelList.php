<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModelList
 *
 * @ORM\Table(name="model_list")
 * @ORM\Entity
 */
class ModelList
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
     * @ORM\Column(name="ml_title", type="string", length=150, nullable=false, options={"default"=""})
     */
    private $mlTitle = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ml_pic_path", type="string", length=150, nullable=false, options={"default"=""})
     */
    private $mlPicPath = '';

    /**
     * @var int
     *
     * @ORM\Column(name="ml_category_id", type="smallint", nullable=false, options={"default"="0"})
     */
    private $mlCategoryId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ml_model_name", type="string", length=45, nullable=false, options={"default"=""})
     */
    private $mlModelName = '';

    /**
     * @var int
     *
     * @ORM\Column(name="ml_view_nums", type="integer", nullable=false, options={"comment"="浏览次数", "default"="0"})
     */
    private $mlViewNums = '0';
}
