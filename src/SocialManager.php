<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2017 Eridan Domoratskiy
 */

namespace SocialFeedCore;

/**
 * Socials (SocialSource classes) manager
 * @author ProgMiner
 */
class SocialManager implements \ArrayAccess {

    /**
     * Socials array
     * @var array
     */
    private $socials = [];

    /**
     * Unregisters a social source class
     * @param string $id Id or social source class name
     * @return void
     * @throws \UnexpectedValueException
     */
    public static function unregisterSocial(string $id) {
        if (isset(static::$socials[$id])) {
            unset(static::$socials[$id]);
            return;
        }

        if (!SocialSource::isSocialSource($id)) {
            throw new \UnexpectedValueException("Social \"{$id}\" isn't registered");
        }

        $key = array_search($id, static::$socials, true);

        if ($key !== false) {
            unset(static::$socials[$key]);
        }
    }

    /**
     * Returns list of all registered social source classes
     * @return array Social source classes list
     */
    public static function getSocialsList(): array {
        return static::$socials;
    }

    public function offsetExists($offset): bool {

    }

    public function offsetGet($offset) {

    }

    /**
     * Registers a social
     * @param string $offset Social's name, gets from {@see SocialSource::getSocialName()} if empty
     * @param string $value Social's class name
     * @return void
     * @throws \UnexpectedValueException
     */
    public function offsetSet($offset, $value) {
        if (!is_string($offset)) {
            throw new \Exception('Social\'s name must be a string');
            // TODO Exception
        }
        
        if (!is_string($value)) {
            throw new \Exception('Social\'s class name must be a string');
            // TODO Exception
        }
        
        if (!SocialSource::isSocialSource($value)) {
            throw new \UnexpectedValueException("Class \"{$value}\" isn't a SocialSource");
        }

        if (empty($offset)) {
            $offset = $value::getSocialName();
        }

        $this->socials[$offset] = $value;
    }

    public function offsetUnset($offset) {
        if (isset($this->socials[$offset])) {
            unset($this->socials[$offset]);
            return;
        }

        if (!SocialSource::isSocialSource($offset)) {
            throw new \UnexpectedValueException("Social \"{$id}\" isn't registered");
        }

        $key = array_search($id, static::$socials, true);

        if ($key !== false) {
            unset($this->socials[$key]);
        }
    }

}
