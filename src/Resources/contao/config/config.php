<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    seven communications GmbH & Co. KG <support@seven.io>
 * @license   MIT
 * @copyright 2022 sms77 e.K.
 * @copyright 2023-present seven communications GmbH & Co. KG
 */

use Seven\ContaoNotificationCenterBundle\NotificationCenter\Gateway\Seven;

$GLOBALS['NOTIFICATION_CENTER']['GATEWAY']['seven'] = Seven::class;

$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'] = array_merge_recursive(
    (array)$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'],
    [
        'contao' => [
            'core_form' => [
                'seven_recipient_number' => [
                    'form_*',
                ],
                'seven_text' => [
                    'form_*',
                    'formconfig_*',
                    'raw_data',
                    'admin_email',
                ],
                'seven_sender_name' => [
                    'form_*',
                ],
            ],
            'member_registration' => [
                'seven_recipient_number' => [
                    'member_mobile',
                    'member_phone',
                ],
                'seven_text' => [
                    'domain',
                    'link',
                    'member_*',
                    'admin_email',
                ],
                'seven_sender_name' => [
                    'member_*',
                ],
            ],
            'member_personaldata' => [
                'seven_recipient_number' => [
                    'member_mobile',
                    'member_phone',
                ],
                'seven_text' => [
                    'domain',
                    'member_*',
                    'member_old_*',
                    'admin_email',
                ],
                'seven_sender_name' => [
                    'member_*',
                ],
            ],
            'member_password' => [
                'seven_recipient_number' => [
                    'member_mobile',
                    'member_phone',
                ],
                'seven_text' => [
                    'domain',
                    'link',
                    'member_*',
                    'admin_email',
                ],
                'seven_sender_name' => [
                    'member_*',
                ],
            ],
        ],
    ]
);
