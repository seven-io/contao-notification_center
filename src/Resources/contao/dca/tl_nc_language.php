<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    sms77 e.K. <support@sms77.io>
 * @license   MIT
 * @copyright 2022-present sms77 e.K.
 */

$GLOBALS['TL_DCA']['tl_nc_language']['palettes']['sms77'] =
    '{general_legend},language,fallback;{meta_legend},sms77_sender_name,sms77_recipient_number;{content_legend},sms77_text';

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['sms77_sender_name'] = [
    'eval' => [
        'decodeEntities' => true,
        'rgxp' => 'nc_tokens',
        'tl_class' => 'w50',
    ],
    'exclude' => true,
    'inputType' => 'text',
    'sql' => 'varchar(16) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['sms77_recipient_number'] = [
    'eval' => [
        'decodeEntities' => true,
        'mandatory' => true,
        'rgxp' => 'nc_tokens',
        'tl_class' => 'long clr',
    ],
    'exclude' => true,
    'inputType' => 'text',
    'sql' => 'varchar(255) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['sms77_text'] = [
    'eval' => [
        'decodeEntities' => true,
        'mandatory' => true,
        'rgxp' => 'nc_tokens',
        'tl_class' => 'clr',
    ],
    'exclude' => true,
    'inputType' => 'textarea',
    'sql' => 'text NULL',
];
