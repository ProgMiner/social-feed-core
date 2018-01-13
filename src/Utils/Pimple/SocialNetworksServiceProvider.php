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

    public function register(Container $cont) {
        $cont['social.networks_factory'] = $cont->factory(function() {
            return new SocialManager();
        });

        $cont['social.networks.import_force'] = false;
        $cont['social.networks.import_list'] = [
            VKSocialSource::class
        ];

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
