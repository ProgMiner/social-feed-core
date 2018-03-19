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

namespace SocialFeedCore;

use SocialFeedCore\Utility\RequestOptions;

/**
 * An interface for a cached data providers
 *
 * @author ProgMiner
 */
interface ICache {

    /**
     * Returns filtered list of posts by options
     *
     * Performs $filter($post) for every post.
     * $filter must returns bool
     *
     * @param string         $networkClass INetwork implementations class name
     * @param RequestOptions $options      Request options
     * @param callable|null  $filter       Callable filter
     *
     * @return Post[]
     */
    public function getPosts(string $networkClass, RequestOptions $options, callable $filter = null);

    /**
     * Caches (saves in cache) posts
     *
     * @param string $networkClass INetwork implementation class name
     * @param Post[] $posts
     */
    public function cachePosts(string $networkClass, array $posts);
}
