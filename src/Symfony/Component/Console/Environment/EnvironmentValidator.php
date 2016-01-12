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

use Symfony\Component\Console\Environment\Constraint\ConstraintInterface;
use Symfony\Component\Console\Environment\Validator\ValidatorInterface;

/**
 * @author SpacePossum
 */
class EnvironmentValidator
{
    /**
     * @var Environment
     */
    private $env;
    private $validators;

    public function __construct(Environment $env)
    {
        $this->env = $env;
        $this->registerBuildInValidators();
    }

    private function registerBuildInValidators()
    {
        $this->validators = array(
            'Symfony\Component\Console\Environment\Constraint\ExtensionConstraint' => 'Symfony\Component\Console\Environment\Validator\ExtensionValidator',
            'Symfony\Component\Console\Environment\Constraint\OSConstraint' => 'Symfony\Component\Console\Environment\Validator\PHPValidator',
            'Symfony\Component\Console\Environment\Constraint\PHPConstraint' => 'Symfony\Component\Console\Environment\Validator\OSValidator',
        );
    }

    /**
     * @param ConstraintInterface[] $constraints
     */
    public function validate(array $constraints)
    {
        foreach ($constraints as $constraint) {
            $constraintClass = get_class($constraint);
            if (!array_key_exists($constraintClass, $this->validators)) {
                throw new \InvalidArgumentException(sprintf('No validator known for constraint class "%s".', $constraintClass));
            }

            /** @var ValidatorInterface $validator */
            $validator = new $this->validators[$constraintClass]();
            if (!$validator instanceof ValidatorInterface) {
                throw new \UnexpectedValueException(sprintf('Validator "%s" for constraint class "%s" must implement the ValidatorInterface.', $this->validators[$constraintClass], $constraintClass));
            }

            $validator->validate($this->env, $constraint);
        }
    }
}
