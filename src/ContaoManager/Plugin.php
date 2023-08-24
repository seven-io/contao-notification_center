<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    seven communications GmbH & Co. KG <support@seven.io>
 * @license   MIT
 * @copyright 2022 sms77 e.K.
 * @copyright 2023-present seven communications GmbH & Co. KG
 */

namespace Seven\ContaoNotificationCenterBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Seven\ContaoNotificationCenterBundle\ContaoNotificationCenterBundle;

class Plugin implements BundlePluginInterface {
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array {
        return [
            BundleConfig::create(ContaoNotificationCenterBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, 'notification_center']),
        ];
    }
}
