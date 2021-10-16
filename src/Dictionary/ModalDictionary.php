<?php

declare(strict_types=1);

namespace App\Dictionary;

use JetBrains\PhpStorm\ArrayShape;

class ModalDictionary
{
    public const SINCE_BLOCK_ID = 'datepicker-since';
    public const SINCE_ACTION_ID = 'datepicker-since-action';
    public const TILL_BLOCK_ID = 'datepicker-till';
    public const TILL_ACTION_ID = 'datepicker-till-action';

    #[ArrayShape([
        'type' => 'string',
        'callback_id' => 'string',
        'title' => 'array',
        'submit' => 'array',
        'close' => 'array',
        'blocks' => 'array[]'
    ])]
    public static function getAddModal(): array
    {
        return [
            'type' => 'modal',
            'callback_id' => InteractionDictionary::ADD_CALLBACK,
            'title' => [
                'type' => 'plain_text',
                'text' => 'Want to work from home?',
                'emoji' => true
            ],
            'submit' => [
                'type' => 'plain_text',
                'text' => 'Submit',
                'emoji' => true
            ],
            'close' => [
                'type' => 'plain_text',
                'text' => 'Cancel',
                'emoji' => true
            ],
            'blocks' => [
                [
                    'type' => 'input',
                    'block_id' => self::SINCE_BLOCK_ID,
                    'element' => [
                        'type' => 'datepicker',
                        'placeholder' => [
                            'type' => 'plain_text',
                            'text' => 'Select a date',
                            'emoji' => true
                        ],
                        'action_id' => self::SINCE_ACTION_ID
                    ],
                    'label' => [
                        'type' => 'plain_text',
                        'text' => 'Since when?',
                        'emoji' => true
                    ]
                ],
                [
                    'type' => 'input',
                    'block_id' => self::TILL_BLOCK_ID,
                    'element' => [
                        'type' => 'datepicker',
                        'placeholder' => [
                            'type' => 'plain_text',
                            'text' => 'Select a date',
                            'emoji' => true
                        ],
                        'action_id' => self::TILL_ACTION_ID
                    ],
                    'label' => [
                        'type' => 'plain_text',
                        'text' => 'Till when?',
                        'emoji' => true
                    ]
                ]
            ]
        ];
    }
}
