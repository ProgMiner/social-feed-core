<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2017 Eridan Domoratskiy
 */

namespace SocialFeedCore;

/**
 * Social sources manager
 * @author ProgMiner
 */
class SocialManager implements \ArrayAccess {

    /**
     * Socials array
     * @var array
     */
    private static $socials = [];

    /**
     * Social sources array
     * @var array
     */
    private $socialSources = [];

    /**
     * Registers a NEW social source class
     *
     * If a class or id (with $rewrite = false)
     * already registered throws OutOfRangeException
     * @param string $className Social source class name
     * @param string $id Optional id for social source class
     * @param bool $rewrite If true social source class will be replaced
     * @return void
     * @throws \UnexpectedValueException
     * @throws \OutOfRangeException
     */
    public static function registerSocial(string $className, $id = null,
                                          bool $rewrite = false) {
        if (!SocialSource::isSocialSource($className)) {
            throw new \UnexpectedValueException("Class \"{$className}\" isn't a SocialSource");
        }

        if (in_array($className, static::$socials, true)) {
            throw new \OutOfRangeException("Social source class\"{$className}\" already registered");
        }

        if (!is_null($id)) {
            $id = $className::getSocialName();
        }

        if (!$rewrite && isset(static::$socials[$id])) {
            throw new \OutOfRangeException("Social \"{$id}\" already registered");
        }

        static::$socials[$id] = $className;
    }

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

    public function offsetSet($offset, $value): void {

    }

    public function offsetUnset($offset): void {

    }

}
