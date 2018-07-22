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

namespace SocialFeedCore\Utility;

/**
 * A trait for collecting validated data
 *
 * @author Eridan Domoratskiy
 */
trait OptionsTrait {

    /**
     * @var array Array of raw data
     */
    protected $raw = [];

    /**
     * @var array Array of validated data
     */
    protected $validated = [];

    /**
     * Validates data
     *
     * @param array Data for validation
     *
     * @return array Validated data
     */
    protected abstract function _validate(array $options): array;

    /**
     * @param array $init Initialization data
     */
    public function __construct(array $init = []) {
        $this->raw = $init;
        $this->validate();
    }

    /**
     * Merges data from an object of same class or an array
     *
     * @param static   $src       Source
     * @param callable $mergeFunc Function for merging
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function mergeWith($src, callable $mergeFunc = null) {
        if (is_null($mergeFunc)) {
            $mergeFunc = 'array_merge';
        }

        if (is_a($src, static::class, true)) {
            $src = $src->raw;
        } else {
            throw new \InvalidArgumentException('Source must be a '.static::class);
        }

        $merged = $mergeFunc($this->raw, $src);

        return new static($merged);
    }

    /**
     * Returns an array with data from object
     *
     * @return array Data
     */
    public function toArray() {
        return $this->validated;
    }

    /**
     * Validates data in object
     *
     * @return $this
     */
    public function validate() {
        $this->validated = $this->_validate($this->raw);

        return $this;
    }

    /**
     * Sets raw data equals to validated
     */
    public function cleanRaw() {
        $this->validate();
        $this->raw = $this->validated;
    }

    public function __isset($key) {
        return isset($this->validated[$key]);
    }

    public function __get($key) {
        return $this->validated[$key];
    }

    public function __set($key, $value) {
        $this->raw[$key] = $value;
        $this->validate();
    }

    public function __unset($key) {
        unset($this->raw[$key]);
        $this->validate();
    }
}
