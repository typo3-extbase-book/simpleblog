<?php
/**
 * Comments
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\BlogStatistics;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;

/**
 * Comments class
 */
class Comments
{
    /**
     * Count comments of the last x days (default: 14 days). Returns an array: ['data' => ..., 'labels' => ... ]
     *
     * @param int Days
     * @return array
     */
    public static function countCommentsOfLastDays($days = 14): array
    {
        $timestamp = strtotime('-' . intval($days) . ' days');
        $startDate = date('Y-m-d 00:00:00', $timestamp);
        $endDate = date('Y-m-d 00:00:00');

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_simpleblog_domain_model_comment');
        $queryBuilder
            ->getRestrictions()
            ->removeByType(HiddenRestriction::class);

        // SELECT commentdate
        // FROM tx_simpleblog_domain_model_comment
        // WHERE commentdate >= '2019-03-02 00:00:00'
        // AND commentdate < '2019-03-09 00:00:00'
        // ORDER BY commentdate ASC

        $query = $queryBuilder
            ->select('commentdate')
            ->from('tx_simpleblog_domain_model_comment')
            ->where(
                $queryBuilder->expr()->gte(
                    'commentdate',
                    $queryBuilder->createNamedParameter($startDate, \PDO::PARAM_STR)
                )
            )
            ->andWhere(
                $queryBuilder->expr()->lt(
                    'commentdate',
                    $queryBuilder->createNamedParameter($endDate, \PDO::PARAM_STR)
                )
            )
            ->orderBy('commentdate', 'ASC')
            ->execute();

        $comments = [];
        while ($row = $query->fetch()) {
            $comments[] = substr($row['commentdate'], 0, 10);
        }
        $comments = array_count_values($comments);
        $data = [];
        while ($timestamp < time()) {
            $key = date('Y-m-d', $timestamp);
            $data[$key] = (array_key_exists($key, $comments) ? $comments[$key] : 0);
            $timestamp = $timestamp + (60*60*24);
        }
        return [
            'data' => array_values($data),
            'labels' => array_keys($data)
        ];
    }

    /**
     * Count posts of a Blog. Returns an array: ['data' => ..., 'labels' => ... ]
     *
     * @return array
     */
    public static function countPostsOfBlogs(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_simpleblog_domain_model_post');
        $queryBuilder
            ->getRestrictions()
            ->removeByType(HiddenRestriction::class);

        // SELECT COUNT(blog.uid), blog.title
        // FROM tx_simpleblog_domain_model_post post, tx_simpleblog_domain_model_blog blog
        // WHERE post.blog = blog.uid
        // GROUP BY blog.uid;

        $query = $queryBuilder
            ->select('blog.title')
            ->addSelectLiteral(
                $queryBuilder->expr()->count('blog.uid', 'counter')
            )
            ->from('tx_simpleblog_domain_model_post', 'post')
            ->join(
                'post',
                'tx_simpleblog_domain_model_blog',
                'blog',
                $queryBuilder->expr()->eq(
                    'post.blog',
                    $queryBuilder->quoteIdentifier('blog.uid')
                )
            )
            ->groupBy('blog.uid')
            ->execute();

        $data = [];
        $labels = [];
        while ($row = $query->fetch()) {
            $data[] = $row['counter'];
            $labels[] = $row['title'];
        }

        return [
            'data' => $data,
            'labels' => $labels
        ];
    }
}
