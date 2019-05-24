<?php
/**
 * Blog Repository
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Repository class: Blog
 */
class BlogRepository extends Repository
{
    /**
     * Returns Blogs with a specific search term in the title
     *
     * @param string Search keyword
     * @param int Max number of Blogs to read from storage
     * @return QueryResult
     */
    public function findSearchForm($search, $limit): QueryResult
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $max = $settings['blog']['max'];

        $query = $this->createQuery();
        $query->matching(
            $query->like('title', '%' . $search . '%')
        );
        $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);

        $max = intval($max);
        if ($max > 0) {
            $query->setLimit($max);
        }

        return $query->execute();
    }

    /**
     * Returns the last Blogs created
     *
     * @return QueryResult
     */
    public function findLastRecordCreated(): QueryResult
    {
        $query = $this->createQuery();
        $query->setOrderings(['crdate' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit(1);
        return $query->execute();
    }
}
