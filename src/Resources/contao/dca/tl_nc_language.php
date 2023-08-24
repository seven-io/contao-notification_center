<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    seven communications GmbH & Co. KG <support@seven.io>
 * @license   MIT
 * @copyright 2022 sms77 e.K.
 * @copyright 2023-present seven communications GmbH & Co. KG
 */

$GLOBALS['TL_DCA']['tl_nc_language']['palettes']['seven'] =
    '{general_legend},language,fallback;{meta_legend},seven_sender_name,seven_recipient_number;{content_legend},seven_text';

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['seven_sender_name'] = [
    'eval' => [
        'decodeEntities' => true,
        'rgxp' => 'nc_tokens',
        'tl_class' => 'w50',
    ],
    'exclude' => true,
    'inputType' => 'text',
    'sql' => 'varchar(16) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['seven_recipient_number'] = [
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

$GLOBALS['TL_DCA']['tl_nc_language']['fields']['seven_text'] = [
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
