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
 * A class of sources of posts
 *
 * @author ProgMiner
 */
class Source {

    /**
     * @var INetwork Social network of this source
     */
    protected $network;

    /**
     * @var RequestOptions Default request options for this source
     */
    protected $options;

    /**
     * @param INetwork $network Social network
     * @param RequestOptions $options Initial request options
     */
    public function __construct(INetwork $network, RequestOptions $options) {
        $this->network = $network;
        $this->options = $options;
    }

    /**
     * Returns posts from source
     *
     * @param RequestOptions|array $options Additional options
     *
     * @return Post[] Array of posts
     */
    public function getPosts($options = []): array {
        $options = (clone $this->options)->mergeFrom($options);

        return $this->network->getPosts($options);
    }
}