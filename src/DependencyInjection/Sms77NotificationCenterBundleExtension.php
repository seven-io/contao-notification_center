<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    sms77 e.K. <support@sms77.io>
 * @license   MIT
 * @copyright 2022-present sms77 e.K.
 */

namespace Sms77\ContaoNotificationCenterBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class Sms77NotificationCenterBundleExtension extends Extension {
    public function load(array $configs, ContainerBuilder $container): void {
        $config = $this->processConfiguration(new Configuration, $configs);
        $loader = new YamlFileLoader($container,
            new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('sms77.api_key', $config['api_key'] ?? '');
    }
}
