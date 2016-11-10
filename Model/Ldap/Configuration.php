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
 * @version    ${release.version}
 * @link       http://www.techdivision.com/
 * @link       https://github.com/Magenerds/Ldap
 * @author     Julian Schlarb <j.schlarb@techdivision.com>
 */
namespace Magenerds\Ldap\Model\Ldap;


use Magento\Backend\App\ConfigInterface;

/**
 * Class Configuration
 * @package Magenerds\Ldap\Model\Ldap
 */
class Configuration
{
    const XML_PATH_SERVER_HOST = 'magenerds_ldap/server/host';
    const XML_PATH_SERVER_PORT = 'magenerds_ldap/server/port';
    const XML_PATH_SERVER_USE_TLS = 'magenerds_ldap/server/use_tls';
    const XML_PATH_SERVER_USE_SSL = 'magenerds_ldap/server/use_ssl';
    const XML_PATH_SERVER_BIND_REQUIRES_DN = 'magenerds_ldap/server/bind_requires_dn';
    const XML_PATH_SERVER_BASE_DN = 'magenerds_ldap/server/base_dn';
    const XML_PATH_SERVER_BIND_DN = 'magenerds_ldap/server/bind_dn';
    const XML_PATH_SERVER_BIND_PASSWORD = 'magenerds_ldap/server/bind_password'; //NOSONAR
    const XML_PATH_SERVER_ALLOW_EMPTY_PASSWORD = 'magenerds_ldap/server/allow_empty_password'; //NOSONAR
    const XML_PATH_SERVER_CACHE_PASSWORD = 'magenerds_ldap/server/cache_password'; //NOSONAR
    const XML_PATH_SERVER_ROLE = 'magenerds_ldap/server/role';
    const XML_PATH_SERVER_USER_FILTER = 'magenerds_ldap/server/user_filter';
    const XML_PATH_ATTRIBUTE_USERNAME = 'magenerds_ldap/attribute/username';
    const XML_PATH_ATTRIBUTE_FIRST_NAME = 'magenerds_ldap/attribute/first_name';
    const XML_PATH_ATTRIBUTE_LAST_NAME = 'magenerds_ldap/attribute/last_name';
    const XML_PATH_ATTRIBUTE_EMAIL = 'magenerds_ldap/attribute/email';

    /**
     * @var ConfigInterface
     */
    private $configure;

    /**
     * Configuration constructor.
     * @param ConfigInterface $configure
     */
    public function __construct(ConfigInterface $configure)
    {
        $this->configure = $configure;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_HOST);
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_PORT);
    }

    /**
     * @return string
     */
    public function getUseSsl()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_USE_SSL);
    }

    /**
     * @return string
     */
    public function getBindDn()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_BIND_DN);
    }

    /**
     * @return string
     */
    public function getBindPassword()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_BIND_PASSWORD);
    }

    /**
     * @return string
     */
    public function getBaseDn()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_BASE_DN);
    }

    /**
     * @return string
     */
    public function getUseStartTls()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_USE_TLS);
    }

    /**
     * @return string
     */
    public function getAllowEmptyPassword()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_ALLOW_EMPTY_PASSWORD);
    }

    /**
     * @return string
     */
    public function getBindRequiresDn()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_BIND_REQUIRES_DN);
    }

    /**
     * @return string
     */
    public function getUserFilter()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_USER_FILTER);
    }

    /**
     * @return string
     */
    public function getCachePassword()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_CACHE_PASSWORD);
    }

    /**
     * @return string
     */
    public function getAttributeNameUsername()
    {
        return $this->configure->getValue(static::XML_PATH_ATTRIBUTE_USERNAME);
    }

    /**
     * @return string
     */
    public function getAttributeNameFirstName()
    {
        return $this->configure->getValue(static::XML_PATH_ATTRIBUTE_FIRST_NAME);
    }

    /**
     * @return string
     */
    public function getAttributeNameLastName()
    {
        return $this->configure->getValue(static::XML_PATH_ATTRIBUTE_LAST_NAME);
    }

    /**
     * @return string
     */
    public function getDefaultRoleId()
    {
        return $this->configure->getValue(static::XML_PATH_SERVER_ROLE);
    }

    /**
     * @return string
     */
    public function getAttributeNameEmail()
    {
        return $this->configure->getValue(static::XML_PATH_ATTRIBUTE_EMAIL);
    }

    /**
     * @return array
     */
    public function getLdapConnectionOptions()
    {
        return array(
            'host' => $this->getHost(),
            'port' => $this->getPort(),
            'useSsl' => $this->getUseSsl(),
            'username' => $this->getBindDn(),
            'password' => $this->getBindPassword(),
            'bindRequiresDn' => $this->getBindRequiresDn(),
            'baseDn' => $this->getBaseDn(),
            'allowEmptyPassword' => $this->getAllowEmptyPassword(),
            'useStartTls' => $this->getUseStartTls(),
        );
    }
}
