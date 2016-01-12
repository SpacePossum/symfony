<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Environment;

/**
 * @author SpacePossum
 */
class Environment
{
    /**
     * @param $extensionName
     *
     * @return string|false
     */
    public function getExtensionVersion($extensionName)
    {
        if (!$this->isExtensionLoaded($extensionName)) {
            throw new \InvalidArgumentException(sprintf('Extension "%s" is not loaded.', $extensionName));
        }

        return phpversion($extensionName);
    }

    /**
     * @param string $extensionName
     *
     * @return bool
     */
    public function isExtensionLoaded($extensionName)
    {
        return extension_loaded($extensionName);
    }

    public function getPHPVersionID()
    {
        if (defined('PHP_VERSION_ID')) {
            return PHP_VERSION_ID;
        }
asdasd
        $version = explode('.', PHP_VERSION);
        define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));

    }
}
