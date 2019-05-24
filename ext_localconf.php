<?php
/**
 * Extension local configuration
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ExtbaseBook.Simpleblog',
            'Bloglisting',
            [
                'Blog' => 'list, addForm, add, show, updateForm, update, deleteConfirm, delete',
                'Post' => 'addForm, add, show, updateForm, update, deleteConfirm, delete',
                'Ajax' => 'comment'
            ],
            // non-cacheable actions
            [
                'Blog' => 'list, addForm, add, show, updateForm, update, deleteConfirm, delete',
                'Post' => 'addForm, add, show, updateForm, update, deleteConfirm, delete',
                'Ajax' => 'comment'
            ]
        );

        // Add PageTSConfig (chapter 6)
        $languageFile = 'simpleblog/Resources/Private/Language/locallang_db.xlf';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
            wizards.newContentElement.wizardItems.plugins {
              elements {
                bloglisting {
                  iconIdentifier = simpleblog-plugin-bloglisting
                  title = LLL:EXT:' . $languageFile. ':tx_simpleblog_bloglisting.name
                  description = LLL:EXT:' . $languageFile. ':tx_simpleblog_bloglisting.description
                  tt_content_defValues {
                    CType = list
                    list_type = simpleblog_bloglisting
                  }
                }
              }
              show = *
            }
          }'
        );

        // Register extension icon (chapter 6)
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Imaging\IconRegistry::class
        );
        $iconRegistry->registerIcon(
            'simpleblog-plugin-bloglisting',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:simpleblog/Resources/Public/Icons/user_plugin_bloglisting.svg']
        );

        // Register TypeConverter (chapter 15)
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter(
            \ExtbaseBook\Simpleblog\Property\TypeConverter\UploadedFileReferenceConverter::class
        );
    }
);
