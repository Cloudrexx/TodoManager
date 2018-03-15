<?php

namespace Cx\Modules\TodoManager\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
class Category extends \Cx\Model\Base\EntityBase {
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $todos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->todos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Category
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
     * @return Category
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
     * Add todos
     *
     * @param \Cx\Modules\TodoManager\Model\Entity\Todo $todos
     * @return Category
     */
    public function addTodo(\Cx\Modules\TodoManager\Model\Entity\Todo $todos)
    {
        $this->todos[] = $todos;

        return $this;
    }

    /**
     * Remove todos
     *
     * @param \Cx\Modules\TodoManager\Model\Entity\Todo $todos
     */
    public function removeTodo(\Cx\Modules\TodoManager\Model\Entity\Todo $todos)
    {
        $this->todos->removeElement($todos);
    }

    /**
     * Get todos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTodos()
    {
        return $this->todos;
    }
}
