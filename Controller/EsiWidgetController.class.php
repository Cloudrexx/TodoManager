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
 * EsiWidgetController to parse TODO_LIST widget
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */

namespace Cx\Modules\TodoManager\Controller;

/**
 * EsiWidgetController to parse TODO_LIST widget
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */
class EsiWidgetController extends \Cx\Core_Modules\Widget\Controller\EsiWidgetController {

    /**
     * Parses a widget
     * @param string $name Widget name
     * @param \Cx\Core\Html\Sigma Widget template
     * @param \Cx\Core\Routing\Model\Entity\Response $response Current response
     * @param array $params Array of params
     */
    public function parseWidget($name, $template, $response, $params) {
        if ($name == 'TODO_LIST') {
            // If no user is logged in we do nothing
            \Cx\Core\Session\Model\Entity\Session::getInstance();
            if (!\FWUser::getFWUserObject()->objUser->login()) {
                return;
            }
            $em = $this->cx->getDb()->getEntityManager();
            $todoRepo = $em->getRepository(
                'Cx\Modules\TodoManager\Model\Entity\Todo'
            );
            // get all todos of current user
            $todos = $todoRepo->findBy(
                array(
                    'user' => \FWUser::getFWUserObject()->objUser->getId(),
                    'done' => false,
                )
            );
            // if user has no todos show nice error message
            if (!count($todos)) {
                global $_ARRAYLANG;
                $template->setVariable(
                    $name,
                    $_ARRAYLANG['TXT_MODULE_TODOMANAGER_NO_TODOS']
                );
                return;
            }
            // show as viewgenerator template
            $vg = new \Cx\Core\Html\Controller\ViewGenerator($todos, array(
                'Cx\Modules\TodoManager\Model\Entity\Todo' => array(
                    'fields' => array(
                        'id' => array(
                            'showOverview' => false,
                        ),
                        'done' => array(
                            'showOverview' => false,
                        ),
                        'user' => array(
                            'showOverview' => false,
                        ),
                    ),
                ),
            ));
            $template->setVariable($name, $vg);
            return;
        }
    }
}
