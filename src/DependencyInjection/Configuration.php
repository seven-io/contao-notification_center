<?php declare(strict_types=1);

/**
 * @package   ContaoNotificationCenterBundle
 * @author    sms77 e.K. <support@sms77.io>
 * @license   MIT
 * @copyright 2022-present sms77 e.K.
 */

namespace Sms77\ContaoNotificationCenterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface {
    public function getConfigTreeBuilder(): TreeBuilder {
        $treeBuilder = new TreeBuilder('sms77'); // sms77_notification_center
        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('api_key')
            ->defaultValue('%env(default::SMS77_API_KEY)%')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
