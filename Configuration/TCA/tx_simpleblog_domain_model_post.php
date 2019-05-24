<?php
/**
 * TYPO3 Configuration Array (TCA) for the Post domain model
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

$languageFile = 'simpleblog/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => 'LLL:EXT:' . $languageFile . ':tx_simpleblog_domain_model_post',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,content',
        'iconfile' => 'EXT:simpleblog/Resources/Public/Icons/tx_simpleblog_domain_model_post.gif',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
        'languageField' => 'sys_language_uid',
        'translationSource' => 'l10n_source',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, title, content, postdate, comments, author, tags',
    ],
    'types' => [
        '1' => [
            'showitem' => 'hidden, title, content, postdate, comments, author, tags, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'crdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.crdate',
            'config' => [
                'type' => 'input'
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'title' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_simpleblog_domain_model_post.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'content' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_simpleblog_domain_model_post.content',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'postdate' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_simpleblog_domain_model_post.postdate',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime',
                'default' => null,
            ],
        ],
        'comments' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_simpleblog_domain_model_post.comments',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_simpleblog_domain_model_comment',
                'foreign_field' => 'post',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'author' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_simpleblog_domain_model_post.author',
            'config' => [
                //'type' => 'inline',
                'type' => 'select',
                //'foreign_table' => 'tx_simpleblog_domain_model_author',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
//                'appearance' => [
//                    'collapseAll' => 0,
//                    'levelLinksPosition' => 'top',
//                    'showSynchronizationLink' => 1,
//                    'showPossibleLocalizationRecords' => 1,
//                    'showAllLocalizationLink' => 1
//                ],
            ],
        ],
        'tags' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_simpleblog_domain_model_post.tags',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_simpleblog_domain_model_tag',
                'MM' => 'tx_simpleblog_post_tag_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],

        ],

        'blog' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
        'l18n_parent' => [
            'exclude' => true,
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        '',
                        0
                    ]
                ],
                'foreign_table' => 'tt_content',
                'foreign_table_where' =>
                    'AND tt_content.pid=###CURRENT_PID### AND tt_content.sys_language_uid IN (-1,0)',
                'default' => 0
            ]
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'l18n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''
            ]
        ],
    ],
];
