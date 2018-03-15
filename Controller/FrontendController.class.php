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
 * Specific FrontendController for this Component. Use this to easily create a frontent view
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */

namespace Cx\Modules\TodoManager\Controller;

/**
 * Specific FrontendController for this Component. Use this to easily create a frontent view
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */
class FrontendController extends \Cx\Core\Core\Model\Entity\SystemComponentFrontendController {

    /**
     * Use this to parse your frontend page
     *
     * You will get a template based on the content of the resolved page
     * You can access Cx class using $this->cx
     * To show messages, use \Message class
     * @param \Cx\Core\Html\Sigma $template Template containing content of resolved page
     */
    public function parsePage(\Cx\Core\Html\Sigma $template, $cmd) {
        $em = $this->cx->getDb()->getEntityManager();
        $todoRepo = $em->getRepository(
            $this->getNamespace() . '\Model\Entity\Todo'
        );
        switch ($cmd) {
            case 'Detail':
                $params = $this->cx->getRequest()->getUrl()->getParamArray();
                if (!isset($params['id'])) {
                    \Cx\Core\Csrf\Controller\Csrf::redirect(
                        \Cx\Core\Routing\Url::fromModuleAndCmd(
                            $this->getName()
                        )
                    );
                }
                $todo = $todoRepo->find(
                    $params['id']
                );
                $this->parseTodo($template, $todo);
                break;
            default:
                // TODO: We should add paging for performance
                $todos = $todoRepo->findAll();
                if (!count($todos)) {
                    $template->hideBlock('todos');
                    $template->touchBlock('no_todos');
                    return;
                }
                foreach ($todos as $todo) {
                    $this->parseTodo($template, $todo);
                    $template->setVariable(
                        'DETAIL_URL',
                        \Cx\Core\Routing\Url::fromModuleAndCmd(
                            $this->getName(),
                            'Detail',
                            '',
                            array('id' => $todo->getId())
                        )
                    );
                    $template->parse('todo');
                }
                break;
        }
    }

    /**
     * Parses a Todo entity into a template
     * @param \Cx\Core\View\Model\Entity\Sigma $template Template to parse into
     * @param \Cx\Modules\TodoManager\Model\Entity\Todo $todo Todo to parse
     */
    protected function parseTodo($template, $todo) {
        $template->setVariable(
            $this->getSystemComponentController()->getSubstitutionArrayForTodo($todo)
        );
        if ($todo->getDone()) {
            $template->touchBlock('todo_done');
            $template->hideBlock('todo_open');
        } else {
            $template->touchBlock('todo_open');
            $template->hideBlock('todo_done');
        }
    }
}
