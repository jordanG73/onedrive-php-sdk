<?php

/**
 * This file is part of Krizalys' OneDrive SDK for PHP.
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @author    Christophe Vidal
 * @copyright 2008-2019 Christophe Vidal (http://www.krizalys.com)
 * @license   https://opensource.org/licenses/BSD-3-Clause 3-Clause BSD License
 * @link      https://github.com/krizalys/onedrive-php-sdk
 */

namespace Krizalys\Onedrive\Parameter;

/**
 * A class to build parameters.
 *
 * @since 2.3.0
 */
class ParameterBuilder implements ParameterBuilderInterface
{
    /**
     * @var \Krizalys\Onedrive\Parameter\Definition\ParameterDefinitionInterface[string]
     *      The parameter definitions.
     */
    private $parameterDefinitions;

    /**
     * @var mixed[string]
     *      The options.
     */
    private $options;

    /**
     * Constructor.
     *
     * @since 2.3.0
     */
    public function __construct()
    {
        $this->parameterDefinitions = [];
        $this->options              = [];
    }

    /**
     * {@inheritDoc}
     *
     * @param ParameterDefinitionInterface[string] $parameterDefinitions
     *        The parameter definitions.
     *
     * @return ParameterBuilderInterface
     *         This instance.
     *
     * @since 2.3.0
     */
    public function setParameterDefinitions(array $parameterDefinitions)
    {
        $this->parameterDefinitions = $parameterDefinitions;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed[string] $options
     *        The options.
     *
     * @return ParameterBuilderInterface
     *         This instance.
     *
     * @since 2.3.0
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string[string]
     *         The parameters.
     *
     * @since 2.3.0
     */
    public function build()
    {
        $defs = array_intersect_key($this->parameterDefinitions, $this->options);
        $keys = array_keys($defs);

        $values = array_map(function ($key) use ($defs) {
            $value = $this->options[$key];

            return $defs[$key]->serializeValue($value);
        }, $keys);

        $keys = array_map(function ($key) use ($defs) {
            return $defs[$key]->serializeKey();
        }, $keys);

        return array_combine($keys, $values);
    }
}