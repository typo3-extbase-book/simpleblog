<?php
/**
 * Filter Controller
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
 * Filter controller class
 */
class FilterController extends AbstractWidgetController
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
     *
     * @param string $char
     */
    public function indexAction(string $char = ""): void
    {
        $query = $this->objects->getQuery();
        $query->matching($query->like($this->property, $char . '%'));
        $modifiedObjects = $query->execute();
        $this->view->assign('contentArguments', [
            $this->as => $modifiedObjects
        ]);
        $this->view->assign('letters', range('A', 'Z'));
        $this->view->assign('char', $char);
    }
}
