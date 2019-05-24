<?php
/**
 * Tag Repository
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Repository class: Tag
 */
class TagRepository extends Repository
{
    /**
     * Default sort order
     *
     * @var array
     */
    protected $defaultOrderings = [
        'tagvalue' => QueryInterface::ORDER_ASCENDING
    ];
}
