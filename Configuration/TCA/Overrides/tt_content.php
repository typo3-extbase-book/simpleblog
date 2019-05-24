<?php
/**
 * TYPO3 Configuration Array (TCA) to override the tt_content model
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ExtbaseBook.Simpleblog',
    'Bloglisting',
    'Simpleblog',
    'EXT:simpleblog/Resources/Public/Icons/user_plugin_bloglisting.svg'
);

// include FlexForm of plugin "Bloglisting" of extension EXT:simpleblog
$pluginSignature = 'simpleblog_bloglisting';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:simpleblog/Configuration/FlexForms/Simpleblog_Bloglisting.xml'
);
