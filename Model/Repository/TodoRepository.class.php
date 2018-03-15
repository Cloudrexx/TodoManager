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
 * Repository for Todos
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */

namespace Cx\Modules\TodoManager\Model\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for Todos
 *
 * @copyright   Cloudrexx AG
 * @author      Michael Ritter <michael.ritter@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  module_todomanager
 */
class TodoRepository extends EntityRepository
{
    /**
     * @inheritdoc
     */
    public function find($id, $lockMode = \Doctrine\DBAL\LockMode::NONE, $lockVersion = null)
    {
        \Cx\Core\Setting\Controller\Setting::init('TodoManager', 'config');
        $hideDone = \Cx\Core\Setting\Controller\Setting::getValue('hide_done');
        $entity = parent::find($id, $lockMode, $lockVersion);
        if ($entity && $hideDone && $entity->getDone()) {
            return null;
        }
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        \Cx\Core\Setting\Controller\Setting::init('TodoManager', 'config');
        $hideDone = \Cx\Core\Setting\Controller\Setting::getValue('hide_done');
        if ($hideDone) {
            $criteria['done'] = false;
        }
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        \Cx\Core\Setting\Controller\Setting::init('TodoManager', 'config');
        $hideDone = \Cx\Core\Setting\Controller\Setting::getValue('hide_done');
        if ($hideDone) {
            $criteria['done'] = false;
        }
        return parent::findBy($criteria, $orderBy);
    }
}
