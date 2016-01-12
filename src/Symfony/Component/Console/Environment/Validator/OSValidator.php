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
use Symfony\Component\Console\Environment\Environment;

/**
 * @author SpacePossum
 */
final class OSValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate(Environment $env, ConstraintInterface $constraint)
    {
        // TODO: Implement validate() method.
    }
}
