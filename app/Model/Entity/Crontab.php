<?php

namespace app\Model\Entity;

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
     * @ORM\Column(name="add_user_id", type="smallint", nullable=false, options={"default"="1"})
     */
    private $addUserId = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="zt_id", type="smallint", nullable=false, options={"default"="1"})
     */
    private $ztId = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false, options={"comment"="名称"})
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="process_id", type="string", length=50, nullable=false, options={"comment"="进程id"})
     */
    private $processId = '';

    /**
     * @var int
     *
     * @ORM\Column(name="time_start", type="integer", nullable=false, options={"comment"="开始时间"})
     */
    private $timeStart = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="time_end", type="integer", nullable=false, options={"comment"="结束时间"})
     */
    private $timeEnd = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="time_spend", type="float", precision=10, scale=0, nullable=false, options={"comment"="消耗时间"})
     */
    private $timeSpend = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="msg", type="string", length=500, nullable=false, options={"comment"="消息结果"})
     */
    private $msg = '';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=false, options={"comment"="任务状态"})
     */
    private $status = '0';



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set updateTime.
     *
     * @param \DateTime $updateTime
     *
     * @return Crontab
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime.
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set isApproval.
     *
     * @param bool $isApproval
     *
     * @return Crontab
     */
    public function setIsApproval($isApproval)
    {
        $this->isApproval = $isApproval;

        return $this;
    }

    /**
     * Get isApproval.
     *
     * @return bool
     */
    public function getIsApproval()
    {
        return $this->isApproval;
    }

    /**
     * Set addUserId.
     *
     * @param int $addUserId
     *
     * @return Crontab
     */
    public function setAddUserId($addUserId)
    {
        $this->addUserId = $addUserId;

        return $this;
    }

    /**
     * Get addUserId.
     *
     * @return int
     */
    public function getAddUserId()
    {
        return $this->addUserId;
    }

    /**
     * Set ztId.
     *
     * @param int $ztId
     *
     * @return Crontab
     */
    public function setZtId($ztId)
    {
        $this->ztId = $ztId;

        return $this;
    }

    /**
     * Get ztId.
     *
     * @return int
     */
    public function getZtId()
    {
        return $this->ztId;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Crontab
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set processId.
     *
     * @param string $processId
     *
     * @return Crontab
     */
    public function setProcessId($processId)
    {
        $this->processId = $processId;

        return $this;
    }

    /**
     * Get processId.
     *
     * @return string
     */
    public function getProcessId()
    {
        return $this->processId;
    }

    /**
     * Set timeStart.
     *
     * @param int $timeStart
     *
     * @return Crontab
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    /**
     * Get timeStart.
     *
     * @return int
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }

    /**
     * Set timeEnd.
     *
     * @param int $timeEnd
     *
     * @return Crontab
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * Get timeEnd.
     *
     * @return int
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    /**
     * Set timeSpend.
     *
     * @param float $timeSpend
     *
     * @return Crontab
     */
    public function setTimeSpend($timeSpend)
    {
        $this->timeSpend = $timeSpend;

        return $this;
    }

    /**
     * Get timeSpend.
     *
     * @return float
     */
    public function getTimeSpend()
    {
        return $this->timeSpend;
    }

    /**
     * Set msg.
     *
     * @param string $msg
     *
     * @return Crontab
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    /**
     * Get msg.
     *
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Crontab
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
