<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    seven communications GmbH & Co. KG <support@seven.io>
 * @license   MIT
 * @copyright 2022 sms77 e.K.
 * @copyright 2023-present seven communications GmbH & Co. KG
 */

$GLOBALS['TL_DCA']['tl_nc_gateway']['palettes']['seven'] =
    '{title_legend},title,type;{gateway_legend},seven_apiKey';

$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['seven_apiKey'] = [
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'w50',
    ],
    'exclude' => true,
    'inputType' => 'text',
    'sql' => 'varchar(90) NOT NULL default \'\'',
];
