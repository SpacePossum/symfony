<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Environment;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Environment\Constraint\ExtensionConstraint;
use Symfony\Component\Console\Environment\Constraint\PHPConstraint;
use Symfony\Component\Console\Environment\Environment;
use Symfony\Component\Console\Environment\Validator\ExtensionValidator;

/**
 * @author SpacePossum
 *
 * @internal
 */
final class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    public function testEnvironmentBasics()
    {
        $appMock = new \ReflectionClass('Symfony\Component\Console\Application');
        $constraintsProperty = $appMock->getProperty('environmentConstraints');
        $constraintsProperty->setAccessible(true);

        $application = new Application();
        $constraint = new PHPConstraint();

        $this->assertInstanceOf('Symfony\Component\Console\Environment\Environment', $application->getEnvironment());
        $this->assertEquals($constraintsProperty->getValue($application), array());

        $application->addEnvironmentConstraint($constraint);
        $this->assertEquals($constraintsProperty->getValue($application), array($constraint));
    }

    // Extension constraints

    /**
     * @expectedException \Symfony\Component\Console\Environment\Validator\EnvironmentConstraintFailException
     * @expectedExceptionMessage Required extension "test_dummy_extension" is not loaded.
     */
    public function testEnvironmentExtensionConstraintMissingFail()
    {
        $appMock = new \ReflectionClass('Symfony\Component\Console\Application');
        $validateMethod = $appMock->getMethod('validateEnvironment');
        $validateMethod->setAccessible(true);

        $application = new Application();
        $application->addEnvironmentConstraint(new ExtensionConstraint('test_dummy_extension'));

        $validateMethod->invoke($application);
    }

    /**
     * @param string $name
     * @param string $version
     *
     * @dataProvider provideLoadedExtensionsAndVersions
     */
    public function testEnvironmentExtensionConstraintVersion($name, $version)
    {
        $env = new Environment();
        $validator = new ExtensionValidator();
        $this->assertTrue($validator->validate($env, new ExtensionConstraint($name)));
        $this->assertTrue($validator->validate($env, new ExtensionConstraint($name, $version)));
        $this->assertTrue($validator->validate($env, new ExtensionConstraint($name, $version, '==')));
        $this->assertTrue($validator->validate($env, new ExtensionConstraint($name, $version, '>=')));
        $this->assertTrue($validator->validate($env, new ExtensionConstraint($name, $version, '<=')));
    }

    /**
     * @param string $name
     * @param string $version
     *
     * @dataProvider provideLoadedExtensionsAndVersions
     *
     * @expectedException \Symfony\Component\Console\Environment\Validator\EnvironmentConstraintFailException
     * @expectedExceptionMessageRegExp #Version of extension "(.*)": "(1.*)" is not equal to "(.*)".#
     */
    public function testEnvironmentExtensionConstraintNotVersion($name, $version)
    {
        $env = new Environment();
        $validator = new ExtensionValidator();
        $validator->validate($env, new ExtensionConstraint($name, '1'.$version));
    }

    public function provideLoadedExtensionsAndVersions()
    {
        $extensions = array();
        $all = get_loaded_extensions();
        foreach ($all as $extensionName) {
            if (false !== $version = phpversion($extensionName)) {
                $extensions[] = array($extensionName, $version);
            }
        }

        return $extensions;
    }

    // PHP Constraint

}
