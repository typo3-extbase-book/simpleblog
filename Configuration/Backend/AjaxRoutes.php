<?php
/**
 * DummyText ViewHelper
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

/**
 * Definitions for routes provided by EXT:simpleblog
 */
return [
    'simpleblog_dispatch' => [
        'path' => '/simpleblog/ajax',
        'target' => \ExtbaseBook\Simpleblog\Controller\AjaxDispatcher::class . '::dispatch'
    ]
];
