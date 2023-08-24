<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    seven communications GmbH & Co. KG <support@seven.io>
 * @license   MIT
 * @copyright 2022 sms77 e.K.
 * @copyright 2023-present seven communications GmbH & Co. KG
 */

namespace Seven\ContaoNotificationCenterBundle\EventListener;

use Contao\StringUtil;
use Contao\System;
use Contao\Validator;
use RuntimeException;

class SaveCallbackListener {
    /**
     * @Callback(table="tl_nc_language", target="fields.seven_sender_name.save")
     * @param mixed $value
     * @return mixed
     * @noinspection PhpUnused
     */
    public function onSaveSevenSenderName($value) {
        if ('' !== $value) {
            if (false !== strpos($value, '##') || false !== strpos($value, '{{'))
                return $value;

            $valid = true;
            if (Validator::isAlphanumeric($value)) {
                if (strlen($value) > 11) $valid = false;
            } else {
                if (!preg_match('/^[1-9][0-9]{0,15}$/', $value)) $valid = false;
            }

            if ($valid) throw new RuntimeException(
                $GLOBALS['TL_LANG']['ERR']['seven_invalid_sender']);
        }

        return $value;
    }

    /**
     * @Callback(table="tl_nc_language", target="fields.seven_recipient_number.save")
     * @param mixed $value
     * @return mixed
     * @noinspection PhpUnused
     */
    public function onSaveSevenRecipientNumber($value) {
        if ('' !== $value) foreach (StringUtil::trimsplit(',', $value) as $chunk) {
            if (false !== strpos($chunk, '##') || false !== strpos($chunk, '{{')) continue;

            if (!Validator::isPhone($chunk))
                throw new RuntimeException($GLOBALS['TL_LANG']['ERR']['phone']);
        }

        return $value;
    }

    /**
     * @Callback(table="tl_nc_gateway", target="config.onload")
     * @noinspection PhpUnused
     */
    public function onLoadTable() {
        if (!System::getContainer()->hasParameter('seven.api_key')) return;

        $GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['seven_apiKey']['eval']['disabled']
            = true;
        $GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['seven_apiKey']['eval']['mandatory']
            = false;
    }

    /**
     * @Callback(table="tl_nc_gateway", target="fields.seven_apiKey.load")
     * @param mixed $value
     * @return mixed
     * @noinspection PhpUnused
     */
    public function onLoadSevenApiKey($value) {
        $container = System::getContainer();
        return $container->hasParameter('seven.api_key')
            ? $container->getParameter('seven.api_key') : $value;
    }

    /**
     * @Callback(table="tl_nc_gateway", target="fields.seven_apiKey.save")
     * @param mixed $value
     * @return mixed
     * @noinspection PhpUnused
     */
    public function onSaveSevenApiKey($value) {
        return System::getContainer()->hasParameter('seven.api_key') ? '' : $value;
    }
}
