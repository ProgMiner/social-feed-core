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

/**
 * Options for requesting posts
 *
 * @author ProgMiner
 */
class RequestOptions implements ConfigurationInterface {
    use OptionsTrait;

    public function getConfigTreeBuilder() {
        static $treeBuilder;

        if (is_null($treeBuilder)) {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('request_options');

            $rootNode->
                children()->

                    integerNode('sourceId')->
                        defaultValue(0)->
                    end()->

                    integerNode('id')->
                        defaultValue(0)->
                    end()->

                    integerNode('count')->
                        defaultValue(0)->
                    end()->

                    variableNode('meta')->
                    end()->

                end();

            return $treeBuilder;
        }

        return $treeBuilder;
    }

    protected function _validate(array $options): array {
        static $processor;

        if (is_null($processor)) {
            $processor = new Processor();
        }

        return $processor->processConfiguration($this, [$options]);
    }
}
