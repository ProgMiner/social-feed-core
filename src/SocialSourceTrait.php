<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore;

/**
 * Trait for social sources
 *
 * @author ProgMiner
 */
trait SocialSourceTrait {

    /**
     * Global source's settings
     *
     * @var array
     */
    public static $global = [];

    /**
     * Is social initialized
     *
     * @var bool
     */
    private static $_init = false;

    /**
     * Social initialize options
     *
     * @var array|callable
     */
    private static $_initOptions = null;

    /**
     * Local source's settings
     *
     * @var type
     */
    protected $settings = [];

    protected abstract static function _init();

    /**
     * Initializes a social network class or sets init options for lazy using
     *
     * @param array $initOptions Init global options
     */
    public static function init($initOptions = null) {
        if (static::$_init !== false) {
            return;
        }

        if (is_array($initOptions) || is_callable($initOptions)) {
            static::$_initOptions = $initOptions;
            return;
        }

        if (is_callable(static::$_initOptions)) {
            $initOptions = static::$_initOptions(static::class);
        } elseif (is_array(static::$_initOptions)) {
            $initOptions = static::$_initOptions;
        }

        static::_init();
        static::$global = array_merge(static::$global, $initOptions);

        static::$_init = true;
    }

    /**
     * @param mixed $offset Setting name
     *
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
     *
     * @return mixed Setting value
     *
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
