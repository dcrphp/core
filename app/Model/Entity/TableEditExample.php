<?php

namespace app\Model\Entity;

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
     * @ORM\Column(name="string_input", type="string", length=45, nullable=false)
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
     * @ORM\Column(name="select", type="string", length=45, nullable=false)
     */
    private $select = '';

    /**
     * @var string
     *
     * @ORM\Column(name="radio", type="string", length=45, nullable=false)
     */
    private $radio = '';

    /**
     * @var string
     *
     * @ORM\Column(name="checkbox", type="string", length=45, nullable=false)
     */
    private $checkbox = '';

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
     * Set addTime.
     *
     * @param \DateTime $addTime
     *
     * @return TableEditExample
     */
    public function setAddTime($addTime)
    {
        $this->addTime = $addTime;

        return $this;
    }

    /**
     * Get addTime.
     *
     * @return \DateTime
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * Set updateTime.
     *
     * @param \DateTime $updateTime
     *
     * @return TableEditExample
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
     * @return TableEditExample
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
     * @return TableEditExample
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
     * @return TableEditExample
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
     * Set stringInput.
     *
     * @param string $stringInput
     *
     * @return TableEditExample
     */
    public function setStringInput($stringInput)
    {
        $this->stringInput = $stringInput;

        return $this;
    }

    /**
     * Get stringInput.
     *
     * @return string
     */
    public function getStringInput()
    {
        return $this->stringInput;
    }

    /**
     * Set textInput.
     *
     * @param string $textInput
     *
     * @return TableEditExample
     */
    public function setTextInput($textInput)
    {
        $this->textInput = $textInput;

        return $this;
    }

    /**
     * Get textInput.
     *
     * @return string
     */
    public function getTextInput()
    {
        return $this->textInput;
    }

    /**
     * Set select.
     *
     * @param string $select
     *
     * @return TableEditExample
     */
    public function setSelect($select)
    {
        $this->select = $select;

        return $this;
    }

    /**
     * Get select.
     *
     * @return string
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * Set radio.
     *
     * @param string $radio
     *
     * @return TableEditExample
     */
    public function setRadio($radio)
    {
        $this->radio = $radio;

        return $this;
    }

    /**
     * Get radio.
     *
     * @return string
     */
    public function getRadio()
    {
        return $this->radio;
    }

    /**
     * Set checkbox.
     *
     * @param string $checkbox
     *
     * @return TableEditExample
     */
    public function setCheckbox($checkbox)
    {
        $this->checkbox = $checkbox;

        return $this;
    }

    /**
     * Get checkbox.
     *
     * @return string
     */
    public function getCheckbox()
    {
        return $this->checkbox;
    }
}
