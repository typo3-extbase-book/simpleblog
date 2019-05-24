<?php
/**
 * Extension configuration
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Simple Blog Extension',
    'description' => 'Demo extension to implement a simple Blog, based on the \"TYPO3 Extbase\" book.',
    'category' => 'plugin',
    'author' => 'Michael Schams',
    'author_email' => 'michael@example.com',
    'state' => 'alpha',
    'uploadfolder' => 1,
    'createDirs' => 'fileadmin/simpleblog',
    'clearCacheOnLoad' => 0,
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.999',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
