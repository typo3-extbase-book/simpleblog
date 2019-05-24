<?php
/**
 * Tag Domain Model
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Domain Model: Tag
 */
class Tag extends AbstractValueObject
{
    /**
     * Tag
     *
     * @var string
     * @Validate("NotEmpty")
     */
    protected $tagvalue = '';

    /**
     * Returns the tagvalue
     *
     * @return string $tagvalue
     */
    public function getTagvalue()
    {
        return $this->tagvalue;
    }

    /**
     * Sets the tagvalue
     *
     * @param string $tagvalue
     * @return void
     */
    public function setTagvalue($tagvalue)
    {
        $this->tagvalue = $tagvalue;
    }
}
