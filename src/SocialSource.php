<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2017 Eridan Domoratskiy
 */

namespace SocialFeedCore;

use SocialFeedCore\Utils\Post;

/**
 * Abstract social source
 * @author ProgMiner
 */
abstract class SocialSource extends \ArrayAccess {

    /**
     * Returns name of social
     * @return string
     */
    public abstract static function getSocialName(): string;

    /**
     * Returns post by id
     * @param int $id Post id
     * @return Post
     */
    public abstract function getPost(int $id): Post;

    /**
     * Returns posts by options
     * @param array $options Getting options
     * @return array Array of Posts
     */
    public abstract function getPosts(array $options = []): array;

    /**
     * Returns new posts after time
     * @param DateTime $after Time
     * @return array Array of Posts
     */
    public abstract function getNewPosts(\DateTime $after): array;

    /**
     * Returns last posts
     * @param int $count Count (0 for all)
     * @return array Array of Posts
     */
    public abstract function getLastPosts(int $count): array;

    public final static function isSocialSource(string $className): bool {
        if (!class_exists($className, true)) {
            return false;
        }

        if (!is_subclass_of($className, self::class, true)) {
            return false;
        }

        return true;
    }

}
