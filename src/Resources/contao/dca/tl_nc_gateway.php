<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    sms77 e.K. <support@sms77.io>
 * @license   MIT
 * @copyright 2022-present sms77 e.K.
 */

$GLOBALS['TL_DCA']['tl_nc_gateway']['palettes']['sms77'] =
    '{title_legend},title,type;{gateway_legend},sms77_apiKey';

$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['sms77_apiKey'] = [
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'w50',
    ],
    'exclude' => true,
    'inputType' => 'text',
    'sql' => 'varchar(90) NOT NULL default \'\'',
];
