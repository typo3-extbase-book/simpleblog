<?php
/**
 * Filter ViewHelper
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\ViewHelpers\Widget;

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;
use ExtbaseBook\Simpleblog\ViewHelpers\Widget\Controller\FilterController;

/**
 * Filter ViewHelper class
 */
class FilterViewHelper extends AbstractWidgetViewHelper
{
    /**
     * Filter controller class
     *
     * @var FilterController
     */
    protected $controller;

    /**
     * Filter controller class
     *
     * @param FilterController $controller
     */
    public function injectSortController(FilterController $controller): void
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
        $this->registerArgument('as', 'mixed', 'as', true);
        $this->registerArgument('property', 'mixed', 'Property', true);
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
