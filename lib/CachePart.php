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

/**
 * Part of a cache that associated with source
 *
 * @author Eridan Domoratskiy
 */
class CachePart implements PostProvider {

    /** @var Cache Cache */
    protected $cache;

    /** @var PostProvider Source */
    protected $source;

    /**
     * @param Cache        $cache  Cache
     * @param PostProvider $source Source
     */
    public function __construct(Cache $cache, PostProvider $source) {
        $this->source = $source;
        $this->cache = $cache;
    }

    /**
     * Returns list of posts by options
     *
     * @param Request $request Request options
     *
     * @return Post\Cached[]
     */
    public function getPosts(Request $request) {
        return $this->cache->getPosts($this->source, $request);
    }

    /**
     * Caches (saves in cache) posts
     *
     * @param Post[] $posts
     *
     * @return Post\Cached[] Cached posts
     */
    public function cachePosts(array $posts): array {
        return $this->cache->cachePosts($this->source, $posts);
    }

    /**
     * Removes posts by request and filter solution
     *
     * Performs $filter($post) for every post.
     * $filter must returns bool.
     *
     * @param Request       $request Request
     * @param callable|null $filter  Callable filter
     */
    public function removePosts(Request $request, ?callable $filter = null) {
        $this->cache->removePosts($this->source, $request, $filter);
    }
}
