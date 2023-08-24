<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    seven communications GmbH & Co. KG <support@seven.io>
 * @license   MIT
 * @copyright 2022 sms77 e.K.
 * @copyright 2023-present seven communications GmbH & Co. KG
 */

namespace Seven\ContaoNotificationCenterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface {
    public function getConfigTreeBuilder(): TreeBuilder {
        $treeBuilder = new TreeBuilder('seven'); // seven_notification_center
        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('api_key')
            ->defaultValue('%env(default::SEVEN_API_KEY)%')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
