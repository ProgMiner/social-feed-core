<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore\Utils;

/**
 * Description of Author
 *
 * @author ProgMiner
 */
class Author {

    use DataClassTrait;

    private function requirements() {
        return [
            'id' => function($id) {
                if (!is_int($id) || $id < 0) {
                    throw new \UnexpectedValueException('Id must be positive integer');
                }
                return $id;
            },
            'full_name' => function($full_name) {
                if (!is_string($full_name)) {
                    $full_name = strval($full_name);
                }
                return $full_name;
            },
            'first_name' => function($first_name) {
                if (!is_string($first_name)) {
                    $first_name = strval($first_name);
                }
                return $first_name;
            },
            'avatar' => function($avatar) {
                if (!$this->is_url($avatar)) {
                    throw new \InvalidArgumentException('Avatar must be URL');
                }
                return $avatar;
            },
            'url' => function($url) {
                if (!$this->is_url($url)) {
                    throw new \InvalidArgumentException('URL is not URL');
                }
                return $url;
            }
        ];
    }

    private function defaults() {
        return [
            'last_name' => ''
        ];
    }

}
