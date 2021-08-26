<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    sms77 e.K. <support@sms77.io>
 * @license   MIT
 * @copyright 2022-present sms77 e.K.
 */

use Sms77\ContaoNotificationCenterBundle\NotificationCenter\Gateway\Sms77;

$GLOBALS['NOTIFICATION_CENTER']['GATEWAY']['sms77'] = Sms77::class;

$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'] = array_merge_recursive(
    (array)$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'],
    [
        'contao' => [
            'core_form' => [
                'sms77_recipient_number' => [
                    'form_*',
                ],
                'sms77_text' => [
                    'form_*',
                    'formconfig_*',
                    'raw_data',
                    'admin_email',
                ],
                'sms77_sender_name' => [
                    'form_*',
                ],
            ],
            'member_registration' => [
                'sms77_recipient_number' => [
                    'member_mobile',
                    'member_phone',
                ],
                'sms77_text' => [
                    'domain',
                    'link',
                    'member_*',
                    'admin_email',
                ],
                'sms77_sender_name' => [
                    'member_*',
                ],
            ],
            'member_personaldata' => [
                'sms77_recipient_number' => [
                    'member_mobile',
                    'member_phone',
                ],
                'sms77_text' => [
                    'domain',
                    'member_*',
                    'member_old_*',
                    'admin_email',
                ],
                'sms77_sender_name' => [
                    'member_*',
                ],
            ],
            'member_password' => [
                'sms77_recipient_number' => [
                    'member_mobile',
                    'member_phone',
                ],
                'sms77_text' => [
                    'domain',
                    'link',
                    'member_*',
                    'admin_email',
                ],
                'sms77_sender_name' => [
                    'member_*',
                ],
            ],
        ],
    ]
);
