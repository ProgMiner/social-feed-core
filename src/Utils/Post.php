<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore\Utils;

/**
 * Post from social source
 *
 * @author ProgMiner
 */
class Post {

    use DataClassTrait;

    /**
     * Sorts array of Posts by date
     *
     * @param array $posts Array of Posts
     *
     * @return array Sorted array
     *
     * @throws \RuntimeException
     */
    public static function sortPostsByDate(array $posts, $sortOrder = SORT_DESC): array {
        $dates = [];

        foreach ($posts as $post) {
            if (is_a($post, static::class)) {
                throw new \InvalidArgumentException('Input array contains not a Post(s)');
            }

            $dates[] = $post->date->getTimestamp();
        }

        if (array_multisort($posts, $sortOrder, SORT_REGULAR, $dates) === false) {
            throw new \RuntimeException('An error occured in "array_multisort"');
        }

        return $posts;
    }

    private function requirements() {
        return [
            'id' => function($id) {
                if (!is_int($id) || $id < 0) {
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
            'views'    => 0,
            'likes'    => 0,
            'reposts'  => 0,
            'comments' => 0
        ];
    }

}
