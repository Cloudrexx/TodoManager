<?php declare(strict_types=1);

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
 * Listener to trigger TodoManager/Done event
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */

namespace Cx\Modules\TodoManager\Model\Event;

/**
 * Listener to trigger TodoManager/Done event
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */
class TodoEventListener extends \Cx\Core\Event\Model\Entity\DefaultEventListener {

    /**
     * Whether the current Todo's done property has changed to true
     * @var boolean
     */
    protected $doneChangedToTrue = false;

    /**
     * Triggered on Doctrine's preUpdate event for Todos
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $lea Event arguments
     */
    protected function preUpdate($lea) {
        $this->doneChangedToTrue = (
            $lea->hasChangedField('done') &&
            $lea->getEntity()->getDone() &&
            !$lea->getOldValue('done')
        );
    }

    /**
     * Triggered on Doctrine's postUpdate event for Todos
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $lea Event arguments
     */
    protected function postUpdate($lea) {
        if (!$this->doneChangedToTrue) {
            return;
        }
        $this->cx->getEvents()->triggerEvent(
            'TodoManager/Done',
            array(
                $lea->getEntity(),
            )
        );
    }
}
