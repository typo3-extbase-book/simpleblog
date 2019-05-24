<?php
/**
 * Sort ViewHelper
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\ViewHelpers\Widget;

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;
use ExtbaseBook\Simpleblog\ViewHelpers\Widget\Controller\SortController;

/**
 * Sort ViewHelper
 */
class SortViewHelper extends AbstractWidgetViewHelper
{
    /**
     * Sort controller class
     *
     * @var SortController
     */
    protected $controller;

    /**
     * Sort controller class
     *
     * @param SortController $controller
     */
    public function injectSortController(SortController $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('objects', 'mixed', 'Object', true);
        $this->registerArgument('as', 'mixed', 'as', false);
        $this->registerArgument('property', 'mixed', 'property', false);
    }

    /**
     * Render
     *
     * @return string
     */
    public function render(): string
    {
        return $this->initiateSubRequest();
    }
}
