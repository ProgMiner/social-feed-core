<?php

/*
 * This file is part of SocialFeedCore
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore;

/**
 * Manager of social sources
 * @author ProgMiner
 */
class SocialSourceManager implements \ArrayAccess {

    /**
     * Array of social sources
     * @var array
     */
    protected $sources = [];

    /**
     * Array of social source text ids
     * @var array
     */
    protected $ids = [];

    /**
     * Checks if a social source is exists
     * @param int|string $offset Social source id or text id
     * @return bool
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
     * @param int|string $offset Social source id or text id
     * @return SocialSource
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
     * @param int|string $offset Social source id or text id
     * @param int|SocialSource $value Social source id or object
     * @return void
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
            $this->ids[count($this->sources)] = $offset;
            $this->sources[] = $value;
            return;
        }

        throw new \InvalidArgumentException('Social source id must be integer or string');
    }

    /**
     * Removes social source by id or text id
     * @param int|string $offset Social source id or text id
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
