<?php

/* MIT License

Copyright (c) 2018 Eridan Domoratskiy

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE. */

namespace SocialFeedCore\Cache;

use SocialFeedCore\Cache;
use SocialFeedCore\Post;

/**
 * Indexed cache
 *
 * Cache, where every post have unique ID.
 *
 * @author Eridan Domoratskiy
 */
interface Indexed extends Cache {

    /**
     * {@inheritdoc}
     *
     * @return Post\Indexed[]
     */
    public function getPosts(PostProvider $source, Request $request): array;

    /**
     * {@inheritdoc}
     *
     * @return Post\Indexed[] Cached posts
     */
    public function cachePosts(PostProvider $source, array $posts): array;

    /**
     * Returns list of posts by IDs
     *
     * @param int[] $ids Array of IDs
     *
     * @return Post\Indexed[]
     */
    public function getPostsByID(array $ids): array;

    /**
     * Removes posts by IDs
     *
     * @param int[] $ids Array of IDs
     */
    public function removePostsByID(array $ids);
}
