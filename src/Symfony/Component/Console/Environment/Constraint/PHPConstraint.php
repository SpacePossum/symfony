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
final class PHPConstraint implements ConstraintInterface
{
    private $major;
    private $minor;
    private $release;

    /**
     * @param int      $major
     * @param int|null $minor
     * @param int|null $release
     */
    public function __construct($major, $minor = null, $release = null)
    {
        $this->major = $major;
        $this->minor = $minor;
        $this->release = $release;
    }

    /**
     * @return int
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * @return int|null
     */
    public function getMinor()
    {
        return $this->minor;
    }

    /**
     * @return int|null
     */
    public function getRelease()
    {
        return $this->release;
    }
}
