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
 * Cache
 *
 * @author Eridan Domoratskiy
 */
interface Cache {

    /**
     * Returns list of posts by request
     *
     * @param PostProvider $source  Posts source
     * @param Request      $request Request
     *
     * @return Post\Cached[]
     */
    public function getPosts(PostProvider $source, Request $request): array;

    /**
     * Caches (saves in cache) posts
     *
     * If post is already cached it is updated in cache.
     *
     * @param PostProvider $source Posts source
     * @param Post[]       $posts
     *
     * @return Post\Cached[] Cached posts
     */
    public function cachePosts(PostProvider $source, array $posts);

    /**
     * Removes posts by request and filter solution
     *
     * Performs $filter($post) for every post.
     * $filter must returns bool.
     *
     * @param PostProvider  $source  Posts source
     * @param Request       $request Request
     * @param callable|null $filter  Callable filter
     */
    public function removePosts(PostProvider $source, Request $request, ?callable $filter = null);
}
