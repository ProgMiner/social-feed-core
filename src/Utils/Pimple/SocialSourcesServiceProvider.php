<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore\Utils\Pimple;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use SocialFeedCore\SocialSourceManager;

/**
 * ServiceProvider for a SocialServiceManager
 *
 * @author ProgMiner
 */
class SocialSourcesServiceProvider implements ServiceProviderInterface {

    public function register(Container $cont) {
        $cont['social.sources_factory'] = $cont->factory(function() {
            return new SocialSourceManager();
        });

        $cont['social.sources.import_force'] = false;
        $cont['social.sources.import_list'] = [];

        $cont['social.sources'] = function(Container $cont) {
            $socialSourcesManager = $cont['social.sources_factory'];

            $importList = $cont['social.sources.import_list'];

            if ($cont['social.sources.import_force'] === true) {
                $socialSourcesManager->importForce($importList);
            } else {
                $socialSourcesManager->import($importList);
            }

            return $socialSourcesManager;
        };
    }

}