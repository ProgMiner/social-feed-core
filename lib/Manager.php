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
 * Manager of post providers
 *
 * @author Eridan Domoratskiy
 */
class Manager implements IPostProvider {

    /**
     * @var IPostProvider[] Post providers
     */
    public $providers;

    /**
     * @var RequestOptions Default request options of this manager
     */
    public $options;

    /**
     * @param IPostProvider[] $providers Post providers
     * @param RequestOptions  $options   Initial request options
     */
    public function __construct(array $providers, RequestOptions $options) {
        $this->providers = $providers;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosts(RequestOptions $options): array {
        $options = $this->options->mergeWith($options);

        $ret = [];
        foreach ($this->providers as $provider) {
            $ret = array_merge($ret, $provider->getPosts($options));
        }

        return $ret;
    }
}
