<?php
/**
 * Sort Controller
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\ViewHelpers\Widget\Controller;

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Sort controller class
 */
class SortController extends AbstractWidgetController
{
    /**
     * QueryResultInterface class
     *
     * @var QueryResultInterface
     */
    protected $objects;

    /**
     * Initialize arguments
     */
    public function initializeAction(): void
    {
        $this->objects = $this->widgetConfiguration['objects'];
        $this->property = $this->widgetConfiguration['property'];
        $this->as = $this->widgetConfiguration['as'];
    }

    /**
     * Index action
     * @param string $order
     */
    public function indexAction(string $order = QueryInterface::ORDER_DESCENDING): void
    {
        $order = ($order == QueryInterface::ORDER_ASCENDING) ?
            QueryInterface::ORDER_DESCENDING : QueryInterface::ORDER_ASCENDING;

        $query = $this->objects->getQuery();
        $query->setOrderings([$this->property => $order]);
        $modifiedObjects = $query->execute();

        $this->view->assign('contentArguments', [
            $this->as => $modifiedObjects
        ]);
        $this->view->assign('order', $order);
    }
}
