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

    /**
     * Default provider settings
     *
     * @var array
     */
    private static $defaults = [
        'social.sources.import_force' => false,
        'social.sources.import_list' => []
    ];

    public function register(Container $cont) {
        $cont['social.sources_factory'] = $cont->factory(function() {
            return new SocialSourceManager();
        });

        foreach (static::$defaults as $field => $value) {
            if (!isset($cont[$field])) {
                $cont[$field] = $value;
            }
        }

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