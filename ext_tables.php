<?php
/**
 * Extension configuration
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {

        // Domain model "Blog"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_simpleblog_domain_model_blog',
            'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_blog.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_simpleblog_domain_model_blog'
        );

        // Domain model "Post"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_simpleblog_domain_model_post',
            'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_post.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_simpleblog_domain_model_post'
        );

        // Domain model "Comment"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_simpleblog_domain_model_comment',
            'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_comment.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_simpleblog_domain_model_comment'
        );

        // Domain model "Author"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_simpleblog_domain_model_author',
            'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_author.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_simpleblog_domain_model_author'
        );

        // Domain model "Tag"
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_simpleblog_domain_model_tag',
            'EXT:simpleblog/Resources/Private/Language/locallang_csh_tx_simpleblog_domain_model_tag.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_simpleblog_domain_model_tag'
        );

        // Register backend module (chapter 16)
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'ExtbaseBook.simpleblog',
            'tools',
            'SimpleblogAdmin',
            'bottom',
            [
                'Dashboard' => 'index',
                'Comment' => 'list'
            ],
            [
                'access' => 'systemMaintainer',
                'icon' => 'EXT:simpleblog/Resources/Public/Icons/module-simpleblog.png',
                'labels' => 'LLL:EXT:simpleblog/Resources/Private/Language/locallang_mod.xlf',
            ]
        );
    }
);
