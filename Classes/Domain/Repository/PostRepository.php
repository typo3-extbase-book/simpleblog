<?php
/**
 * Post Repository
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Repository class: Post
 */
class PostRepository extends Repository
{
    /**
     * Returns the last post created
     *
     * @return QueryResult
     */
    public function findLastRecordCreated(): QueryResult
    {
        $query = $this->createQuery();
        $query->setOrderings(['postdate' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit(1);
        return $query->execute();
    }
}
