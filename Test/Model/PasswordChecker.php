<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   Magenerds
 * @package    Magenerds_Ldap
 * @copyright  Copyright (c) 2016 TechDivision GmbH (http://www.techdivision.com)
 * @link       http://www.techdivision.com/
 * @link       https://github.com/Magenerds/Ldap
 * @author     Julian Schlarb <j.schlarb@techdivision.com>
 */
namespace Magenerds\Ldap\Test\Model;


use Magenerds\Ldap\Model\Ldap\Configuration;
use Magenerds\Ldap\Model\Ldap\PasswordValidator;

/**
 * Class PasswordCheckerTest
 *
 * @package Magenerds\Ldap\Test\Model
 */
class PasswordCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Holds a mock of Configuration
     *
     * @var Configuration|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configuration;
    /**
     * @var PasswordValidator
     */
    private $passwordValidator;

    public function testSimple()
    {
        static::assertTrue($this->passwordValidator->validatePassword('123', '123'));
    }

    public function testEmptyAllowed()
    {
        // setup mock functions
        $this->configuration->expects(static::once())
            ->method('getAllowEmptyPassword')
            ->willReturn('1');

        static::assertTrue($this->passwordValidator->validatePassword('', ''));
    }

    public function testEmptyPermit()
    {
        // setup mock functions
        $this->configuration->expects(static::once())
            ->method('getAllowEmptyPassword')
            ->willReturn('0');

        static::assertFalse($this->passwordValidator->validatePassword('', ''));
    }

    public function testSHA()
    {
        static::assertTrue($this->passwordValidator->validatePassword('abcd123', '{SHA}fDYHuOYbzxlE6ehQOmYPIfS28/E='));
    }

    public function testMD5()
    {
        static::assertTrue($this->passwordValidator->validatePassword('helloworld', '{MD5}/F4DjTilcDIIVEHn/nAQsA=='));
    }

    public function testCrypt()
    {
        static::assertTrue($this->passwordValidator->validatePassword('helloworld', '{crypt}0pnSC65.QhkYc'));
    }

    public function testSSHA()
    {
        $hash = '{SSHA}UqeHYFMhsBo/mwjFP1rNxcmKP9//OZmK';

        static::assertTrue($this->passwordValidator->validatePassword('abcd123', $hash));
    }

    /**
     * @expectedException LocalizedException
     */
    public function testUnsupportedHashFormat()
    {
        $this->passwordValidator->validatePassword('12345', '{NOT}12345');
    }

    protected function setUp()
    {
        $this->configuration = $this->getMockBuilder(Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->passwordValidator = new PasswordValidator($this->configuration);
    }
}
