<?php
/**
 * DummyText ViewHelper
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * DummyText ViewHelper class
 */
class DummyTextViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('length', 'int', 'Length of the dummy text');
    }

    /**
     * Render
     *
     * @param array
     * @param \Closure
     * @param RenderingContextInterface
     * @return string
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        $length = intval($arguments['length'] ?: 100);
        $dummytext = $renderChildrenClosure() ?: 'Lorem ipsum dolor sit amet.';
        $repeat = ceil($length / strlen($dummytext));
        $content = substr(str_repeat($dummytext . ' ', $repeat), 0, $length) . '.';
        return $content;
    }
}
