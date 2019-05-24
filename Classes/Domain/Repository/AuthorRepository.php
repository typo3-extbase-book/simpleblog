<?php
/**
 * Author Repository
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * Repository class: Author
 */
class AuthorRepository extends Repository
{
    /**
     * Default sort order
     *
     * @var array
     */
    protected $defaultOrderings = [
        'fullname' => QueryInterface::ORDER_ASCENDING
    ];

    /**
     * Initialize object
     */
    public function initializeObject(): void
    {
        /** @var $querySettings Typo3QuerySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }
}
