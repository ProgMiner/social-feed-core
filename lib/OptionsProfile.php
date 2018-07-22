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
 * Profile with default options for {@see IPostProvider::getPosts}
 *
 * @author Eridan Domoratskiy
 */
class OptionsProfile implements IPostProvider {

    /**
     * @var IPostProvider Original post provider
     */
    public $orig;

    /**
     * @var RequestOptions Default options
     */
    public $options;

    /**
     * @param IPostProvider $orig
     * @param RequestOptions $options
     */
    public function __construct(IPostProvider $orig, RequestOptions $options) {
        $this->orig = $orig;
        $this->options = $options;
    }

    /**
     * Returns a posts
     *
     * @param RequestOptions $options An additional options
     *
     * @return Post[] Array of Posts
     */
    public function getPosts(RequestOptions $options): array {
        return $this->orig->getPosts(
            $this->options->mergeWith($options)
        );
    }
}
