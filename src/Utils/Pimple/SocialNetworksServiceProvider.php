<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore\Utils\Pimple;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use SocialFeedCore\Utils\SocialManager;
use SocialFeedCore\SocialSources\VKSocialSource;

/**
 * ServiceProvider for a SocialManager
 *
 * @author ProgMiner
 */
class SocialNetworksServiceProvider implements ServiceProviderInterface {

    /**
     * Default provider settings
     *
     * @var array
     */
    private static $defaults = [
        'social.networks.import_force' => false,
        'social.networks.import_list' => [
            VKSocialSource::class
        ]
    ];

    public function register(Container $cont) {
        $cont['social.networks_factory'] = $cont->factory(function() {
            return new SocialManager();
        });

        foreach (static::$defaults as $field => $value) {
            if (!isset($cont[$field])) {
                $cont[$field] = $value;
            }
        }

        $cont['social.networks'] = function(Container $cont) {
            $socialManager = $cont['social.networks_factory'];

            $importList = $cont['social.networks.import_list'];

            if ($cont['social.networks.import_force'] === true) {
                $socialManager->importForce($importList);
            } else {
                $socialManager->import($importList);
            }

            return $socialManager;
        };
    }

}
