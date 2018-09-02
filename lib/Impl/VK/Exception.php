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

namespace SocialFeedCore\Impl\VK;

use SocialFeedCore\Exception as Base;

/**
 * VK API exception
 *
 * @author Eridan Domoratskiy
 */
class Exception extends Base\API {

    /**
     * @param mixed      $request  Request that caused an error
     * @param mixed      $response Full response from API with error
     * @param \Throwable $previous Previous exception
     */
    public function __construct($request, $response, \Throwable $previous = null) {
        parent::__construct(
            $request,
            $response,
            $response->error->error_msg,
            $response->error->error_code,
            $previous
        );
    }

    /**
     * Checks for an error and throws an exception
     * if it contains an error
     *
     * @param mixed $request  Request that caused an error
     * @param mixed $response Full response from API with error
     */
    public static function checkError($request, $response) {
        if (isset($response->error)) {
            throw new static($request, $response);
        }
    }
}
