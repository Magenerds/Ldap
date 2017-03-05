<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace Magenerds\Ldap\Api;

/**
 * @category   Magenerds
 * @package    Magenerds_Ldap
 * @subpackage Model
 * @copyright  Copyright (c) 2017 TechDivision GmbH (http://www.techdivision.com)
 * @link       http://www.techdivision.com/
 * @author     Julian Schlarb <j.schlarb@techdivision.com>
 */
interface ConfigInterface
{
    /**
     * deployment configuration path
     */
    const CONFIG_KEY_HOST = 'ldap/host';
    const CONFIG_KEY_PORT = 'ldap/port';
    const CONFIG_KEY_USE_TLS = 'ldap/use-tls';
    const CONFIG_KEY_USE_SSL = 'ldap/use-ssl';
    const CONFIG_KEY_BIND_REQUIRES_DN = 'ldap/bind-requires-dn';
    const CONFIG_KEY_BASE_DN = 'ldap/base-dn';
    const CONFIG_KEY_BIND_DN = 'ldap/bind-dn';
    const CONFIG_KEY_BIND_PASSWORD = 'ldap/bind-password'; //NOSONAR
    const CONFIG_KEY_ALLOW_EMPTY_PASSWORD = 'ldap/allow-empty-password'; //NOSONAR
    const CONFIG_KEY_CACHE_PASSWORD = 'ldap/cache-password'; //NOSONAR
    const CONFIG_KEY_ROLE = 'ldap/role';
    const CONFIG_KEY_USER_FILTER = 'ldap/user-filter';
    const CONFIG_KEY_ATTRIBUTE_USERNAME = 'ldap/attribute/username';
    const CONFIG_KEY_ATTRIBUTE_FIRST_NAME = 'ldap/attribute/first-name';
    const CONFIG_KEY_ATTRIBUTE_LAST_NAME = 'ldap/attribute/last-name';
    const CONFIG_KEY_ATTRIBUTE_EMAIL = 'ldap/attribute/email';

    /**
     * default values
     */
    const DEFAULT_PORT = '389';
    const DEFAULT_USER_FILTER = '(&(objectClass=*)(:usernameAttribute=:username))';
    const DEFAULT_USE_TLS = false;
    const DEFAULT_USE_SSL = false;
    const DEFAULT_BIND_REQUIRES_DN = false;
    const DEFAULT_ALLOW_EMPTY_PASSWORD = false;
    const DEFAULT_CACHE_PASSWORD = false;
    const DEFAULT_ATTRIBUTE_USERNAME = 'uid';
    const DEFAULT_ATTRIBUTE_FIRST_NAME = 'givenname';
    const DEFAULT_ATTRIBUTE_LAST_NAME = 'sn';
    const DEFAULT_ATTRIBUTE_EMAIL = 'mail';

    function getUserFilter();

    /**
     * @return string
     */
    function getCachePassword();

    /**
     * @return string
     */
    function getAttributeNameUsername();

    /**
     * @return string
     */
    function getAttributeNameFirstName();

    /**
     * @return string
     */
    function getAttributeNameLastName();

    /**
     * @return string
     */
    function getDefaultRoleId();

    /**
     * @return string
     */
    function getAttributeNameEmail();

    /**
     * @return array
     */
    function getLdapConnectionOptions();

    /**
     * @return string
     */
    function getHost();

    /**
     * @return string
     */
    function getPort();

    /**
     * @return string
     */
    function getUseSsl();

    /**
     * @return string
     */
    function getBindDn();

    /**
     * @return string
     */
    function getBindPassword();

    /**
     * @return string
     */
    function getBindRequiresDn();

    /**
     * @return string
     */
    function getBaseDn();

    /**
     * @return string
     */
    function getAllowEmptyPassword();

    /**
     * @return string
     */
    function getUseStartTls();
}