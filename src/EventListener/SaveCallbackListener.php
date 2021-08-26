<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    sms77 e.K. <support@sms77.io>
 * @license   MIT
 * @copyright 2022-present sms77 e.K.
 */

namespace Sms77\ContaoNotificationCenterBundle\EventListener;

use Contao\StringUtil;
use Contao\System;
use Contao\Validator;
use RuntimeException;

class SaveCallbackListener {
    /**
     * @Callback(table="tl_nc_language", target="fields.sms77_sender_name.save")
     * @param mixed $value
     * @return mixed
     */
    public function onSaveSms77SenderName($value) {
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
                $GLOBALS['TL_LANG']['ERR']['sms77_invalid_sender']);
        }

        return $value;
    }

    /**
     * @Callback(table="tl_nc_language", target="fields.sms77_recipient_number.save")
     * @param mixed $value
     * @return mixed
     */
    public function onSaveSms77RecipientNumber($value) {
        if ('' !== $value) foreach (StringUtil::trimsplit(',', $value) as $chunk) {
            if (false !== strpos($chunk, '##') || false !== strpos($chunk, '{{')) continue;

            if (!Validator::isPhone($chunk))
                throw new RuntimeException($GLOBALS['TL_LANG']['ERR']['phone']);
        }

        return $value;
    }

    /**
     * @Callback(table="tl_nc_gateway", target="config.onload")
     */
    public function onLoadTable() {
        if (!System::getContainer()->hasParameter('sms77.api_key')) return;

        $GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['sms77_apiKey']['eval']['disabled']
            = true;
        $GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['sms77_apiKey']['eval']['mandatory']
            = false;
    }

    /**
     * @Callback(table="tl_nc_gateway", target="fields.sms77_apiKey.load")
     * @param mixed $value
     * @return mixed
     */
    public function onLoadSms77ApiKey($value) {
        $container = System::getContainer();
        return $container->hasParameter('sms77.api_key')
            ? $container->getParameter('sms77.api_key') : $value;
    }

    /**
     * @Callback(table="tl_nc_gateway", target="fields.sms77_apiKey.save")
     * @param mixed $value
     * @return mixed
     */
    public function onSaveSms77ApiKey($value) {
        return System::getContainer()->hasParameter('sms77.api_key') ? '' : $value;
    }
}
