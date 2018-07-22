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

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

/**
 * Abstract options powered by {@see ConfigurationInterface}
 *
 * @author Eridan Domoratskiy
 */
abstract class AbstractConfigurationOptions implements ConfigurationInterface {

    /**
     * @var TreeBuilder
     */
    protected $treeBuilder = null;

    /**
     * @var Processor
     */
    protected $processor = null;

    public final function getConfigTreeBuilder() {
        if (is_null($this->treeBuilder)) {
            $this->regenTreeBuilder();
        }

        return $this->treeBuilder;
    }

    /**
     * Regenerates $treeBuilder
     *
     * @return NodeDefinition Root node
     */
    protected abstract function regenTreeBuilder(): NodeDefinition;

    protected final function _validate(array $options): array {
        if (is_null($this->processor)) {
            $this->processor = new Processor();
        }

        return $this->processor->processConfiguration($this, [$options]);
    }
}
