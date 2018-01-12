<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore;

/**
 * Trait for social sources
 * @author ProgMiner
 */
trait SocialSourceTrait {

    /**
     * Global source's settings
     * @var array
     */
    public static $global = [];

    /**
     * Local source's settings
     * @var type
     */
    protected $settings = [];

    /**
     * @param mixed $offset Setting name
     * @return bool
     */
    public function offsetExists($offset): bool {
        if (isset(static::$global[$offset])) {
            return true;
        }

        if (isset($this->settings[$offset])) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $offset Setting name
     * @return mixed Setting value
     * @throws \OutOfRangeException
     */
    public function offsetGet($offset) {
        if (isset($this->settings[$offset])) {
            return $this->settings[$offset];
        }

        if (isset(static::$global[$offset])) {
            return static::$global[$offset];
        }

        throw new \OutOfRangeException("Setting {$offset} is not exists");
    }

    /**
     * @param mixed $offset Setting name
     * @param mixed $value Setting value
     */
    public function offsetSet($offset, $value) {
        $this->settings[$offset] = $value;
    }

    /**
     * @param mixed $offset Setting name
     */
    public function offsetUnset($offset) {
        unset($this->settings[$offset]);
    }

}
