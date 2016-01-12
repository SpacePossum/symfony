<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Environment\Constraint;

/**
 * @author SpacePossum
 */
final class ExtensionConstraint implements ConstraintInterface
{
    private $extensionName;
    private $version;
    private $operator;

    /**
     * @param string      $extensionName Name of the extension.
     * @param string|null $version
     * @param string|null $operator
     */
    public function __construct($extensionName, $version = null, $operator = null)
    {
        $this->extensionName = $extensionName;
        $this->version = $version;
        $this->operator = $operator;
    }

    /**
     * @return string
     */
    public function getExtensionName()
    {
        return $this->extensionName;
    }

    /**
     * @return null|string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return null|string
     */
    public function getVersion()
    {
        return $this->version;
    }
}
