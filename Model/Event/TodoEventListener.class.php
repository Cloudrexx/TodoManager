<?php declare(strict_types=1);

namespace Cx\Modules\TodoManager\Model\Event;

class TodoEventListener extends \Cx\Core\Event\Model\Entity\DefaultEventListener {

    protected $doneChangedToTrue = false;

    protected function preUpdate($lea) {
        $this->doneChangedToTrue = (
            $lea->hasChangedField('done') &&
            $lea->getEntity()->getDone() &&
            !$lea->getOldValue('done')
        );
    }

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
