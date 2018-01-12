<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore;

use SocialFeedCore\Utils\Post;

/**
 * Abstract social source
 * @author ProgMiner
 */
abstract class SocialSource implements \ArrayAccess {

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
     * Returns new posts since $after
     * @param DateTime $after Time
     * @return array Array of Posts
     */
    public abstract function getNewPosts(\DateTime $after, array $options = []): array;

    /**
     * Returns last posts
     * @param int $count Count (0 for all)
     * @return array Array of Posts
     */
    public abstract function getLastPosts(int $count, array $options = []): array;

    /**
     * Checks class is it a subclass of SocialSource
     * @param string $className Name of class to checking
     * @return bool Returns true if class is a subclass of SocialSource, false otherwise
     *
     * @see SocialSource
     */
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
