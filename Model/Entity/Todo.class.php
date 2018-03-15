<?php

namespace Cx\Modules\TodoManager\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Todo
 */
class Todo extends \Cx\Model\Base\EntityBase {
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var boolean
     */
    protected $done;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \DateTime
     */
    protected $reminderDate;

    /**
     * @var \Cx\Modules\TodoManager\Model\Entity\Category
     */
    protected $category;

    /**
     * @var \Cx\Core\User\Model\Entity\User
     */
    protected $user;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set done
     *
     * @param boolean $done
     * @return Todo
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean 
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Todo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Todo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set reminderDate
     *
     * @param \DateTime $reminderDate
     * @return Todo
     */
    public function setReminderDate($reminderDate)
    {
        $this->reminderDate = $reminderDate;

        return $this;
    }

    /**
     * Get reminderDate
     *
     * @return \DateTime 
     */
    public function getReminderDate()
    {
        return $this->reminderDate;
    }

    /**
     * Set category
     *
     * @param \Cx\Modules\TodoManager\Model\Entity\Category $category
     * @return Todo
     */
    public function setCategory(\Cx\Modules\TodoManager\Model\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Cx\Modules\TodoManager\Model\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \Cx\Core\User\Model\Entity\User $user
     * @return Todo
     */
    public function setUser(\Cx\Core\User\Model\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Cx\Core\User\Model\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
