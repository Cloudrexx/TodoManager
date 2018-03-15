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
 * Specific BackendController for this Component.
 *
 * Use the examples here to easily customize the backend of your component.
 * Delete this file if you don't need it. Remove any methods you don't need! 
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */

namespace Cx\Modules\TodoManager\Controller;

/**
 * Specific BackendController for this Component.
 *
 * Use the examples here to easily customize the backend of your component.
 * Delete this file if you don't need it. Remove any methods you don't need! 
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */
class BackendController extends \Cx\Core\Core\Model\Entity\SystemComponentBackendController {

    /**
     * Default permission
     *
     * @var Cx\Core_Modules\Access\Model\Entity\Permission
     */
    protected $defaultPermission;

    /**
     * Returns the object to parse a view with
     *
     * If you overwrite this and return anything else than string, filter will not work
     * @return string|array|object An entity class name, entity, array of entities or DataSet
     */
    protected function getViewGeneratorParseObjectForEntityClass($entityClassName) {
        return $entityClassName;
    }

    /**
     * Returns all entities of this component which can have an auto-generated view
     *
     * @access protected
     * @return array
     */
    protected function getEntityClassesWithView() {
        return $this->getEntityClasses();
    }

    /**
     * This function returns the ViewGeneration options for a given entityClass
     *
     * @access protected
     * @global $_ARRAYLANG
     * @param $entityClassName contains the FQCN from entity
     * @param $dataSetIdentifier if $entityClassName is DataSet, this is used for better partition
     * @return array with options
     */
    protected function getViewGeneratorOptions($entityClassName, $dataSetIdentifier = '') {
        $options = parent::getViewGeneratorOptions($entityClassName, $dataSetIdentifier);

        switch ($entityClassName) {
            case 'Cx\Modules\TodoManager\Model\Entity\Todo':
                $options['fields'] = array(
                    'description' => array(
                        'showOverview' => false,
                    ),
                    'category' => array(
                        'allowFiltering' => true,
                    ),
                );
                $options['functions']['filtering'] = true;
                $options['functions']['searching'] = true;
                break;
            case 'Cx\Modules\TodoManager\Model\Entity\Category':
                $options['fields'] = array(
                    'todos' => array(
                        'showOverview' => false,
                        'showDetail' => false,
                    ),
                );
                break;
        }
        return $options;
    }

    /**
     * Return true here if you want the first tab to be an entity view
     * @return boolean True if overview should be shown, false otherwise
     */
    protected function showOverviewPage() {
        return false;
    }
}

