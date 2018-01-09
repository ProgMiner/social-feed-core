<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2017 Eridan Domoratskiy
 */

namespace SocialFeedCore;

/**
 * Abstract social source
 * @author ProgMiner
 */
interface SocialSource extends \ArrayAccess {

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
}
