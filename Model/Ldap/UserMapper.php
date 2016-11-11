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
namespace Magenerds\Ldap\Model\Ldap;


use Magento\Authorization\Model\Role;
use Magento\Authorization\Model\RoleFactory;
use Magento\User\Model\User;

/**
 * Class UserMapper
 *
 * @package Magenerds\Ldap\Model\Ldap
 */
class UserMapper
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * UserMapper constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param array $ldapAttributes
     * @param string $password
     * @param User $user
     * @return void
     */
    public function mapUser($ldapAttributes, $password, User $user)
    {
        $user->setFirstName($this->getFirstName($ldapAttributes));
        $user->setLastName($this->getLastName($ldapAttributes));
        $user->setUserName($this->getUsername($ldapAttributes));
        $user->setEmail($this->getEmail($ldapAttributes));

        $user->setLdapDn($ldapAttributes['dn']);

        if ($user->isObjectNew()) {
            $user->setIsActive(1);
        }

        $user->setRoleId($this->configuration->getDefaultRoleId());

        if ($this->configuration->getCachePassword()) {
            $user->setPassword($password);
        } else {
            $user->setPassword(uniqid());
        }
    }

    /**
     * @param array $ldapAttributes
     * @return string
     */
    private function getFirstName($ldapAttributes)
    {
        return $this->getFirstAttribute($ldapAttributes, $this->configuration->getAttributeNameFirstName());
    }

    /**
     * @param array $ldapAttributes
     * @param string $name
     * @return string
     */
    private function getFirstAttribute($ldapAttributes, $name)
    {
        return isset($ldapAttributes[$name]) ? $ldapAttributes[$name][0] : '';
    }

    /**
     * @param array $ldapAttributes
     * @return string
     */
    private function getLastName($ldapAttributes)
    {
        return $this->getFirstAttribute($ldapAttributes, $this->configuration->getAttributeNameLastName());
    }

    /**
     * @param array $ldapAttributes
     * @return string
     */
    private function getUsername($ldapAttributes)
    {
        return $this->getFirstAttribute($ldapAttributes, $this->configuration->getAttributeNameUsername());
    }

    /**
     * @param array $ldapAttributes
     * @return string
     */
    private function getEmail($ldapAttributes)
    {
        return $this->getFirstAttribute($ldapAttributes, $this->configuration->getAttributeNameEmail());
    }
}
