<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore\Utils;

use SocialFeedCore\SocialSource;

/**
 * Manager of social networks (SocialSource classes)
 * @author ProgMiner
 */
class SocialManager implements \ArrayAccess {

    /**
     * Array of social networks
     * @var array
     */
    protected $socials = [];

    /**
     * Imports social networks from array
     * @param array $socials Array of social networks to importing
     * @return void
     */
    public function import(array $socials) {
        foreach ($socials as $socialName => $social) {
            if (!is_string($socialName)) {
                $this->offsetSet(null, $social);
            } else {
                $this->offsetSet($socialName, $social);
            }
        }
    }

    /**
     * Merges social networks from array without checks
     *
     * !!!IMPORTANT!!! Use this only for optimizing import from SocialManager::export()
     * @param array $socials Array of social
     * @return void
     *
     * @see SocialManager::export()
     */
    public function importForce(array $socials) {
        $this->socials = array_merge($this->socials, $socials);
    }

    /**
     * Returns a list of all registered social networks
     * @return array List of social networks
     */
    public function export(): array {
        return $this->socials;
    }

    /**
     * Checks if a social network is registered
     * @param string $offset Social network name or class name
     * @return bool True if the social network is registered, false otherwise
     */
    public function offsetExists($offset): bool {
        if (isset($this->socials[$offset])) {
            return true;
        }

        return in_array($offset, $this->socials, true);
    }

    /**
     * Returns a social network class name by name or class name
     * @param string $offset A social network name or class name
     * @return string A social network class name
     */
    public function offsetGet($offset) {
        if (isset($this->socials[$offset])) {
            return $this->socials[$offset];
        }

        if (in_array($offset, $this->socials, true)) {
            return $offset;
        }

        throw new \OutOfBoundsException("Social network \"{$offset}\" isn't registered");
    }

    /**
     * Registers a social network
     * @param string $offset Social network name, gets from $value::getSocialName() if empty
     * @param string $value Social network class name
     * @return void
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @see SocialSource::getSocialName()
     */
    public function offsetSet($offset, $value) {
        if (!is_string($offset) && !is_null($offset)) {
            throw new \InvalidArgumentException('Social network\'s name must be a string');
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException('Social network\'s class name must be a string');
        }

        if (!SocialSource::isSocialSource($value)) {
            throw new \UnexpectedValueException("Class \"{$value}\" isn't a SocialSource");
        }

        if (is_null($offset)) {
            $offset = $value::getSocialName();
        }

        $this->socials[$offset] = $value;
    }

    /**
     * Unregisters a social network
     * @param string $offset Social network name
     * @return void
     * @throws \OutOfBoundsException
     */
    public function offsetUnset($offset) {
        if (isset($this->socials[$offset])) {
            unset($this->socials[$offset]);
            return;
        }

        $key = array_search($offset, $this->socials, true);

        if ($key === false) {
            throw new \OutOfBoundsException("Social network \"{$offset}\" isn't registered");
        }

        unset($this->socials[$key]);
    }

}
