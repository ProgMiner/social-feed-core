<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore\Utils;

/**
 * Trait for data-classes (structures)
 *
 * Requires requirements()
 * method returns array with
 * required data-class fields with
 * validators (or without).
 *
 * Supports defaults()
 * method returns array with
 * defaults field values.
 *
 * @author ProgMiner
 */
trait DataClassTrait {

    /**
     * @var array
     */
    private $data;

    /**
     * Returns data-class config from
     * requirements() and defaults()
     *
     * @return array Requirements and defaults
     * 
     * @throws LogicException
     */
    private function getDataClassConfiguration(): array {
        $requirements = null;
        $defaults = null;

        if (method_exists($this, 'requirements')) {
            $requirements = $this->requirements();
        }

        if (!is_array($requirements)) {
            throw new \LogicException('Data class requirements are not defined');
        }

        if (method_exists($this, 'defaults')) {
            $defaults = $this->defaults();
        }

        return [$requirements, $defaults];
    }

    public function __construct(array $data) {
        list($requirements, $defaults) = $this->getDataClassConfiguration();

        if (is_array($defaults)) {
            $this->data = $defaults;
        }

        foreach ($data as $field => $value) {
            if (!is_string($field)) {
                continue;
            }

            $this->data[$field] = $value;
        }

        foreach ($requirements as $field => $validator) {
            if (is_int($field)) {
                $field = $validator;
            }

            if (!is_callable($validator, false)) {
                unset($validator);
            }

            if (!isset($data[$field])) {
                throw new \UnexpectedValueException('Data hasn\'t required field');
            }

            if (isset($validator)) {
                $data[$field] = $validator($data[$field]);
            }

            $this->data[$field] = $data[$field];
        }
    }

    public function __isset(string $name) {
        return isset($this->data[$name]);
    }

    public function __get(string $name) {
        return $this->data[$name];
    }

    public function __set(string $name, $value) {
        throw new \LogicException('You can\'t edit data in data-class');
    }

    public function __unset(string $name) {
        throw new \LogicException('You can\'t edit data in data-class');
    }

}
