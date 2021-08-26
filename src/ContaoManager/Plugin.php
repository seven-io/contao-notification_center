<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    sms77 e.K. <support@sms77.io>
 * @license   MIT
 * @copyright 2022-present sms77 e.K.
 */

namespace Sms77\ContaoNotificationCenterBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Sms77\ContaoNotificationCenterBundle\ContaoNotificationCenterBundle;

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
