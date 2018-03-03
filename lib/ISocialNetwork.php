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
 * An interface for all social networks
 *
 * @author ProgMiner
 */
interface ISocialNetwork {

    /**
     * Returns options
     *
     * @return RequestOptions
     */
    public function getOptions(): RequestOptions;

    /**
     * Returns posts from social network by options
     *
     * @param RequestOptions $options Request options
     *
     * @return Post[] Array of Posts
     */
    public function getPosts(RequestOptions $options): array;

    /**
     * Returns source from current social network
     *
     * @param int                 $id      Internal identificator of source
     * @param RequestOptions|null $options Additional options for source
     *
     * @return SocialSource
     */
    public abstract function getSource(int $id, $options = null): SocialSource {
        if (is_null($options)) {
            $options = new RequestOptions();
        }

        if (!is_a($options, RequestOptions::class, true)) {
            throw new \InvalidArgumentException('Options must be a '.RequestOptions::class);
        }

        $options->sourceId = $id;

        return new SocialSource($this, $options);
    }
}
