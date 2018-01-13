<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore\SocialSources\Exceptions;

use SocialFeedCore\Utils\DataClassTrait;

/**
 * VKAPI Exception
 *
 * @author ProgMiner
 */
class VKSocialSourceException extends \Exception {

    use DataClassTrait {
        __construct as _construct;
    }

    public function __construct($vkError, \Throwable $previous = null) {
        parent::__construct($vkError->error_msg, $vkError->error_code, $previous);
        $this->_construct([
            'requestParams' => $vkError->request_params
        ]);
    }

    private function requirements(): array {
        return ['requestParams'];
    }

}
