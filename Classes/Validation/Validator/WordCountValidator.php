<?php
/**
 * WordCount Validator
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Validation\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * WordCount Validator class
 */
class WordCountValidator extends AbstractValidator
{
    /**
     * Supported options
     *
     * @var array
     */
    protected $supportedOptions = [
        'maximum' => [PHP_INT_MAX, 'Maximum number of words', 'integer']
    ];

    /**
     * Checks if the given value does not show more than x words
     *
     * @param mixed $value The value that should be validated
     */
    public function isValid($value): void
    {
        $maximum = intval($this->options['maximum']);
        if (!is_string($value) || $this->wordCount($value) > $maximum) {
            $this->addError(
                'Number of words exceeds the maximum of ' . $maximum,
                1548653067
            );
        }
    }

    /**
     * UTF-8 save str_word_count() function
     *
     * @param string $string Input string to evaluate
     * @return int Number of words
     */
    protected function wordCount($string): int
    {
        return intval(count(preg_split('~[^\p{L}\p{N}\']+~u', (string)$string)));
    }
}
