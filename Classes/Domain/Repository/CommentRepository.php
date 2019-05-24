<?php
/**
 * Comment Repository
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
 * Repository class: Comment
 */
class CommentRepository extends Repository
{
    /**
     * Returns the last comment posted
     *
     * @return QueryResult
     */
    public function findLastRecordCreated(): QueryResult
    {
        $query = $this->createQuery();
        $query->setOrderings(['commentdate' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit(1);
        return $query->execute();
    }
}
