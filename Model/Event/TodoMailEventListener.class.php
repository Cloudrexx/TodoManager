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
 * Listener to send mail for done todos
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */

namespace Cx\Modules\TodoManager\Model\Event;

/**
 * Listener to send mail for done todos
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */
class TodoMailEventListener extends \Cx\Core\Event\Model\Entity\DefaultEventListener {

    /**
     * Triggered whenever an event is marked as done
     * @param \Cx\Modules\TodoManager\Model\Entity\Todo $todo The changed Todo
     */
    protected function todoManagerDone($todo) {
        $substitution = $this->cx->getComponent(
            'TodoManager'
        )->getSubstitutionArrayForTodo($todo);
        \Cx\Core\MailTemplate\Controller\MailTemplate::send(array(
            'key' => 'done',
            'section' => 'TodoManager',
            'substitution' => array(
                'open' => array(
                    $substitution,
                ),
                'done' => array(
                    $substitution,
                ),
            ),
        ));
    }
}
