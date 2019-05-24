<?php
/**
 * Blog Validator
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Blog validator class
 */
class BlogValidator extends AbstractValidator
{
    /**
     * Validates the Blog model
     *
     * @param mixed $object
     */
    protected function isValid($object): void
    {
        if ($object->getTitle() == 'Brad Pitt' && preg_match('/Extbase/i', $object->getDescription())) {
            $this->result->forProperty('title')->addError(
                new \TYPO3\CMS\Extbase\Error\Error(
                    'Title can not be "Brad Pitt".',
                    1548665647
                )
            );
            $this->result->forProperty('description')->addError(
                new \TYPO3\CMS\Extbase\Error\Error(
                    'Description should not contain "Extbase".',
                    1548665753
                )
            );
        }
    }
}
