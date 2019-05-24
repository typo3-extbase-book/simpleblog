<?php
/**
 * IsFrontend ViewHelper
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * ViewHelper class to determine if current context is the frontend.
 */
class IsFrontendViewHelper extends AbstractConditionViewHelper
{
    /**
     * Evaluates a TYPO3_MODE condition.
     *
     * @param array $arguments
     * @param RenderingContextInterface $renderingContext
     * @return bool The ViewHelper contents if the user has access to the specified operation.
     */
    public static function verdict(array $arguments, RenderingContextInterface $renderingContext) : bool
    {
        if (TYPO3_MODE === 'FE') {
            return true;
        } else {
            return false;
        }
    }
}
