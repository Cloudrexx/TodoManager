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
 * Specific ComponentController for this Component.
 *
 * Use the examples here to easily customize your component. Delete this file
 * if you don't need it. Remove any methods you don't need! 
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */

namespace Cx\Modules\TodoManager\Controller;

/**
 * Specific ComponentController for this Component.
 *
 * Use the examples here to easily customize your component. Delete this file
 * if you don't need it. Remove any methods you don't need! 
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */
class ComponentController extends \Cx\Core\Core\Model\Entity\SystemComponentController {

    /**
     * Returns all Controller class names for this component (except this)
     *
     * Be sure to return all your controller classes if you add your own
     * @return array List of Controller class names (without namespace)
     */
    public function getControllerClasses() {
        return array('Frontend', 'Backend', 'EsiWidget');
    }

    /**
     * Returns a list of JsonAdapter class names
     *
     * The array values might be a class name without namespace. In that case
     * the namespace \Cx\{component_type}\{component_name}\Controller is used.
     * If the array value starts with a backslash, no namespace is added.
     *
     * Avoid calculation of anything, just return an array!
     * @return array List of ComponentController classes
     */
    public function getControllersAccessableByJson() {
        return array('EsiWidgetController');
    }

    /**
     * Do something after system initialization
     *
     * USE CAREFULLY, DO NOT DO ANYTHING COSTLY HERE!
     * CALCULATE YOUR STUFF AS LATE AS POSSIBLE.
     * This event must be registered in the postInit-Hook definition
     * file config/postInitHooks.yml.
     * @param \Cx\Core\Core\Controller\Cx   $cx The instance of \Cx\Core\Core\Controller\Cx
     */
    public function postInit(\Cx\Core\Core\Controller\Cx $cx) {
        $widgetController = $this->getComponent('Widget');
        $widget = new \Cx\Core_Modules\Widget\Model\Entity\EsiWidget(
            $this,
            'TODO_LIST'
        );
        $widget->setEsiVariable(
            \Cx\Core_Modules\Widget\Model\Entity\EsiWidget::ESI_VAR_ID_USER
        );
        $widgetController->registerWidget(
            $widget
        );
    }

    /**
     * Register your events here
     *
     * Do not do anything else here than list statements like
     * $this->cx->getEvents()->addEvent($eventName);
     */
    public function registerEvents() {
        $this->cx->getEvents()->addEvent($this->getName() . '/Done');
    }

    /**
     * Register your event listeners here
     *
     * USE CAREFULLY, DO NOT DO ANYTHING COSTLY HERE!
     * CALCULATE YOUR STUFF AS LATE AS POSSIBLE.
     * Keep in mind, that you can also register your events later.
     * Do not do anything else here than initializing your event listeners and
     * list statements like
     * $this->cx->getEvents()->addEventListener($eventName, $listener);
     */
    public function registerEventListeners() {
        $todoListener = new \Cx\Modules\TodoManager\Model\Event\TodoEventListener(
            $this->cx
        );
        $this->cx->getEvents()->addModelListener(
            'preUpdate',
            $this->getNamespace() . '\Model\Entity\Todo',
            $todoListener
        );
        $this->cx->getEvents()->addModelListener(
            'postUpdate',
            $this->getNamespace() . '\Model\Entity\Todo',
            $todoListener
        );
        $this->cx->getEvents()->addEventListener(
            $this->getName() . '/Done',
            new \Cx\Modules\TodoManager\Model\Event\TodoMailEventListener(
                $this->cx
            )
        );
    }

    public function getSubstitutionArrayForTodo($todo) {
        $substitution = array(
            'ID' => $todo->getId(),
            'NAME' => contrexx_raw2xhtml($todo->getName()),
            'DESCRIPTION' => contrexx_raw2xhtml($todo->getDescription()),
            'REMINDER_DATE' => $todo->getReminderDate()->format(
                ASCMS_DATE_FORMAT
            ),
        );
        if ($todo->getCategory()) {
            $substitution += array(
                'CATEGORY_ID' => $todo->getCategory()->getId(),
                'CATEGORY_NAME' => contrexx_raw2xhtml(
                    $todo->getCategory()->getName()
                ),
                'CATEGORY_DESCRIPTION' => contrexx_raw2xhtml(
                    $todo->getCategory()->getDescription()
                ),
            );
        }
        if ($todo->getUser()) {
            $substitution += array(
                'USER_ID' => $todo->getUser()->getId(),
                'USER_NAME' => contrexx_raw2xhtml(
                    \FWUser::getParsedUserTitle($todo->getUser())
                ),
            );
        }
        return $substitution;
    }
}
