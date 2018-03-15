<?php declare(strict_types=1);

namespace Cx\Modules\TodoManager\Model\Event;

class TodoMailEventListener extends \Cx\Core\Event\Model\Entity\DefaultEventListener {

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
