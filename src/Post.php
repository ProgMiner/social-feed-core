<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2017 Eridan Domoratskiy
 */

namespace SocialFeedCore;

/**
 * Post from social source
 * @author ProgMiner
 */
class Post {

    use DataClassTrait;

    private function requirements() {
        return [
            'id' => function($id) {
                if (!is_int($id) || $id > 0) {
                    throw new \UnexpectedValueException('Id must be positive integer');
                }
                return $id;
            },
            'date' => function($date) {
                if (is_int($date)) {
                    $date = \DateTime::createFromFormat('U', "{$date}");
                }

                if (is_string($date)) {
                    $date = new \DateTime($date);
                }

                if (!is_a($date, '\DateTime', false)) {
                    throw new \UnexpectedValueException('Date must be unixtime, time string or \DateTime');
                }

                return $date;
            },
            'content' => function($content) {
                if (!is_string($content)) {
                    $content = strval($content);
                }
                return $content;
            }
        ];
    }

    private function defaults() {
        return [
            'views'   => 0,
            'likes'   => 0,
            'reposts' => 0
        ];
    }

}
