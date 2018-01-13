<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore;

use SocialFeedCore\Utils\Post;

/**
 * Manager of social sources
 *
 * @author ProgMiner
 */
class SocialSourceManager implements \ArrayAccess {

    /**
     * Array of social sources
     *
     * @var array
     */
    protected $sources = [];

    /**
     * Array of social source text ids
     *
     * @var array
     */
    protected $ids = [];

    /**
     * Imports social sources from array
     *
     * @param array $sources Array of social sources to importing
     */
    public function import(array $sources) {
        foreach ($sources as $id => $source) {
            if (!is_string($id)) {
                $this[] = $source;
            } else {
                $this[$id] = $source;
            }
        }
    }

    /**
     * Merges social networks from array without checks
     *
     * !!!IMPORTANT!!! Use this only for optimizing import from SocialSourceManager::export()
     *
     * @param array $sources Array of social
     *
     * @see SocialSourceManager::export()
     */
    public function importForce(array $sources) {
        foreach ($sources as $id => $source) {
            if (!is_string($id)) {
                $this->ids[$offset] = count($this->sources);
            }

            $this->sources[] = $source;
        }
    }

    /**
     * Exports social sources as array
     *
     * @return array
     */
    public function export(): array {
        $sources = $this->sources;

        foreach ($this->ids as $id => $index) {
            $sources[$id] = $sources[$index];
            unset($sources[$index]);
        }

        return $sources;
    }

    /**
     * Return social source id by text id if exists
     *
     * @param string $alias Social source text id
     *
     * @return int Social source id
     *
     * @throws \OutOfBoundsException
     */
    public function getId(string $alias): int {
        if (!isset($this->ids[$offset])) {
            throw new \OutOfBoundsException("Social source with text id {$offset} isn't exists");
        }

        return $this->ids[$alias];
    }

    /**
     * Returns new posts since $after
     *
     * @param DateTime $after Time
     *
     * @return array Array of Posts
     */
    public function getNewPosts(\DateTime $after): array {
        $ret = [];

        foreach ($this->sources as $source) {
            $ret = array_merge($ret, $source->getNewPosts($after));
        }

        return Post::sortPostsByDate($ret);
    }

    /**
     * Returns last posts
     *
     * @param int $count Count (0 for all)
     *
     * @return array Array of Posts
     */
    public function getLastPosts(int $count): array {
        $ret = [];

        foreach ($this->sources as $source) {
            $ret = array_merge($ret, $source->getLastPosts($count));
        }

        return Post::sortPostsByDate($ret);
    }

    /**
     * Checks if a social source is exists
     *
     * @param int|string $offset Social source id or text id
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function offsetExists($offset): bool {
        if (is_int($offset)) {
            return isset($this->sources[$offset]);
        }

        if (is_string($offset)) {
            return isset($this->ids[$offset]);
        }

        throw new \InvalidArgumentException('Social source id must be integer or string');
    }

    /**
     * Returns social source by id or text id
     *
     * @param int|string $offset Social source id or text id
     *
     * @return SocialSource
     *
     * @throws \InvalidArgumentException
     */
    public function offsetGet($offset) {
        if (is_int($offset)) {
            return $this->sources[$offset];
        }

        if (is_string($offset)) {
            return $this->sources[$this->ids[$offset]];
        }

        throw new \InvalidArgumentException('Social source id must be integer or string');
    }

    /**
     * Adds new social source with id or text id
     * or adds text id (alias) to id
     *
     * @param int|string $offset Social source id or text id
     * @param int|SocialSource $value Social source id or object
     *
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    public function offsetSet($offset, $value) {
        if (is_string($offset) && is_int($value)) {
            if (!isset($this->sources[$value])) {
                throw new \OutOfBoundsException("Social source with id {$value} isn't exists");
            }

            $this->ids[$offset] = $value;
            return;
        }

        if (!is_a($value, SocialSource::class, false)) {
            throw new \InvalidArgumentException('Social source must be a SocialSource');
        }

        if (is_null($offset)) {
            $this->sources[] = $value;
            return;
        }

        if (is_int($offset)) {
            $this->sources[$offset] = $value;
            return;
        }

        if (is_string($offset)) {
            $this->ids[$offset] = count($this->sources);
            $this->sources[] = $value;
            return;
        }

        throw new \InvalidArgumentException('Social source id must be integer or string');
    }

    /**
     * Removes social source by id or text id
     *
     * @param int|string $offset Social source id or text id
     *
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    public function offsetUnset($offset) {
        if (is_int($offset)) {
            if (!isset($this->sources[$offset])) {
                throw new \OutOfBoundsException("Social source with id {$offset} isn't exists");
            }

            $id = array_search($offset, $this->ids, true);

            if ($id !== false) {
                unset($this->ids[$id]);
            }
            unset($this->sources[$offset]);
        }

        if (is_string($offset)) {
            if (!isset($this->ids[$offset])) {
                throw new \OutOfBoundsException("Social source with text id {$offset} isn't exists");
            }

            unset($this->sources[$this->ids[$offset]]);
            unset($this->ids[$offset]);
        }

        throw new \InvalidArgumentException('Social source id must be integer or string');
    }

}
