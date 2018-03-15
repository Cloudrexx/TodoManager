<?php declare(strict_types=1);

namespace Cx\Modules\TodoManager\Controller;

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
