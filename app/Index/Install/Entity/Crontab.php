<?php

namespace app\Index\Install\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crontab
 *
 * @ORM\Table(name="crontab")
 * @ORM\Entity
 */
class Crontab
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
     * @var bool
     *
     * @ORM\Column(name="is_approval", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isApproval = true;

    /**
     * @var int
     *
     * @ORM\Column(name="add_user_id", type="smallint", nullable=false, options={"default"="1"})
     */
    private $addUserId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="zt_id", type="smallint", nullable=false, options={"default"=1})
     */
    private $ztId = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false, options={"default"="","comment"="名称"})
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="process_id", type="string", length=50, nullable=false, options={"default"="","comment"="进程id"})
     */
    private $processId = '';

    /**
     * @var int
     *
     * @ORM\Column(name="time_start", type="integer", nullable=false, options={"default"=0,"comment"="开始时间"})
     */
    private $timeStart = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="time_end", type="integer", nullable=false, options={"default"=0,"comment"="结束时间"})
     */
    private $timeEnd = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="time_spend", type="float", precision=10, scale=0, nullable=false, options={"default"=0,"comment"="消耗时间"})
     */
    private $timeSpend = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="msg", type="string", length=500, nullable=false, options={"default"="","comment"="消息结果"})
     */
    private $msg = '';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=false, options={"default"=0,"comment"="任务状态"})
     */
    private $status = '0';
}
