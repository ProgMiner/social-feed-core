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

namespace SocialFeedCore\Impl;

use SocialFeedCore\PostProvider;

use SocialFeedCore\Utility\RequestOptions;

use SocialFeedCore\Impl\Exception\VKException;

/**
 * VK.com post provider
 *
 * @author Eridan Domoratskiy
 */
class VKPostProvider implements PostProvider {

    /**
     * Requests VK API method
     *
     * @param string   $method     API method name
     * @param string[] $params     Request parameters
     * @param bool     $checkError If true checks is result contains error 
     *                             and throw exception if contains
     *
     * @return mixed Response object if $checkError = true, full result object otherwise
     *
     * @throws VKException
     */
    public static function api(string $method, array $params = [], bool $checkError = true) {
        $request = "https://api.vk.com/method/{$method}?".http_build_query($params);
        $result = json_decode(file_get_contents($request));

        if (!$checkError) {
            return $result;
        }

        VKException::checkError($request, $result);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosts(RequestOptions $options): array {
        //
    }
}
