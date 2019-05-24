<?php
/**
 * EmailObfuscator ViewHelper
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * EmailObfuscator ViewHelper class
 * https://raw.githubusercontent.com/sergiodlopes/mailto/master/jquery.mailto.min.js
 */
class EmailObfuscatorViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * Tag name
     */
    protected $tagName = 'a';

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('email', 'string', 'Email address to obfuscate', false);
    }

    /**
     * Render
     *
     * @return string
     */
    public function render(): string
    {
        $email = $this->arguments['email'] ?: $this->renderChildren();
        if (GeneralUtility::validEmail($email)) {
            $email = explode('@', $email);
            $this->tag->addAttribute('data-account', $email[0], $escapeSpecialCharacters);
            $this->tag->addAttribute('data-host', $email[1], $escapeSpecialCharacters);
            $this->tag->addAttribute('class', 'email');
            $this->tag->addAttribute('data-text', 'Email');
            $this->tag->forceClosingTag(true);
            return $this->tag->render();
        }
        return '';
    }
}
