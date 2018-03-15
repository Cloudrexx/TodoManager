<?php

/**
 * Cloudrexx
 *
 * @link      http://www.cloudrexx.com
 * @copyright Cloudrexx AG 2007-2015
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Cloudrexx" is a registered trademark of Cloudrexx AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

/**
 * Todo entity
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */

namespace Cx\Modules\TodoManager\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Todo entity
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */
class Todo extends \Cx\Model\Base\EntityBase implements \Gedmo\Translatable\Translatable {
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
     * @var string
     */
    protected $locale;

    /**
     * Sets $this->user to current user if its not set
     */
    public function __construct() {
        if ($this->user) {
            return;
        }
        $userId = \FWUser::getFWUserObject()->objUser->getId();
        if (!$userId) {
            return;
        }
        $em = $this->cx->getDb()->getEntityManager();
        $userRepo = $em->getRepository('Cx\Core\User\Model\Entity\User');
        $this->user = $userRepo->find($userId);
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

    /**
     * Sets the current locale for translation
     * @param string $locale Locale identifier
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}
