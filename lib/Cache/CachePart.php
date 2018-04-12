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

use SocialFeedCore\Utility\RequestOptions;

/**
 * Part of a {@see ICache} for
 * {@see IPostProvider} implementation
 *
 * @author ProgMiner
 */
class CachePart {

    /**
     * @var ICache Cache
     */
    protected $cache;

    /**
     * @var string {@see IPostProvider} implementation class name
     */
    protected $className;

    /**
     * @param ICache $cache     Cache
     * @param string $className {@see IPostProvider} implementation class name
     */
    public function __construct(ICache $cache, string $className) {
        $this->className = $className;
        $this->cache = $cache;
    }

    /**
     * Returns filtered list of posts by options
     *
     * Performs $filter($post) for every post.
     * $filter must returns bool
     *
     * @param RequestOptions $options Request options
     * @param callable|null  $filter  Callable filter
     *
     * @return Post[]
     */
    public function getPosts(RequestOptions $options, callable $filter = null) {
        return $this->cache->getPosts($this->className, $option, $filter);
    }

    /**
     * Caches (saves in cache) posts
     *
     * @param Post[] $posts
     */
    public function cachePosts(array $posts) {
        return $this->cache->cachePosts($this->className, $posts);
    }
}
