<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Environment\Validator;

use Symfony\Component\Console\Environment\Constraint\ConstraintInterface;
use Symfony\Component\Console\Environment\Constraint\ExtensionConstraint;
use Symfony\Component\Console\Environment\Environment;

/**
 * @author SpacePossum
 */
final class ExtensionValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate(Environment $env, ConstraintInterface $constraint)
    {
        if (!$constraint instanceof ExtensionConstraint) {
            throw new \InvalidArgumentException(sprintf('Expected constraint instance of ExtensionConstraint, got "%s".', is_object($constraint) ? get_class($constraint) : gettype($constraint)));
        }

        $extensionName = $constraint->getExtensionName();
        if (!$env->isExtensionLoaded($extensionName)) {
            throw new EnvironmentConstraintFailException(sprintf('Required extension "%s" is not loaded.', $extensionName));
        }

        if (null === $toTestVersion = $constraint->getVersion()) {
            return true;
        }

        $operator = $constraint->getOperator();
        $extensionVersion = $env->getExtensionVersion($extensionName);

        if (null === $operator || '==' === $operator) {
            if ($toTestVersion !== $extensionVersion) {
                throw new EnvironmentConstraintFailException(sprintf('Version of extension "%s": "%s" is not equal to "%s".', $extensionName, $toTestVersion, phpversion($extensionName)));
            }

            return true;
        }

        if (true !== version_compare($toTestVersion, $extensionVersion, $operator)) {
            if ($toTestVersion === $extensionVersion && false !== strpos($operator, '=')) {
                return true;
            }

            throw new EnvironmentConstraintFailException(sprintf('Version of extension "%s" "%s" is not %s "%s".', $extensionName, $toTestVersion, $operator, phpversion($extensionName)));
        }

        return true;
    }
}
