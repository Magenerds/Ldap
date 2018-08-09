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
    const CONFIG_KEY_ATTRIBUTE_ROLE = 'ldap/attribute/role';

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

    /**
     * Returns the LDAP user filter
     *
     * @return string
     */
    function getUserFilter();

    /**
     * Returns true if it's allowed to cache the users password otherwise false
     *
     * @return boolean
     */
    function getCachePassword();

    /**
     * Returns the attribute key in LDAP defining the user’s username.
     *
     * @return string
     */
    function getAttributeNameUsername();

    /**
     * Returns the attribute key in LDAP defining the user’s first name.
     *
     * @return string
     */
    function getAttributeNameFirstName();

    /**
     * Returns the attribute key in LDAP defining the user’s last name.
     *
     * @return string
     */
    function getAttributeNameLastName();

    /**
     * Returns the technical role id
     *
     * @return integer
     */
    function getDefaultRoleId();

    /**
     * Returns the attribute key in LDAP defining the user’s email.
     *
     * @return string
     */
    function getAttributeNameEmail();

    /**
     * Returns the attribute key in LDAP defining the user’s role,
     * otherwise returns the default role specified in the role key.
     *
     * @return string
     */
    function getAttributeNameRole();

    /**
     * Returns an prepared array for the ldap connector
     *
     * @return array
     */
    function getLdapConnectionOptions();

    /**
     * Returns the ldap host
     *
     * @return string
     */
    function getHost();

    /**
     * Returns the ldap port
     *
     * @return string
     */
    function getPort();

    /**
     * Returns true if the ldap connection must be establish via ldaps
     *
     * @return boolean
     */
    function getUseSsl();

    /**
     * Returns the bind dn
     *
     * @return string
     */
    function getBindDn();

    /**
     * Returns the bind password
     *
     * @return string
     */
    function getBindPassword();

    /**
     * Returns true if bind is required
     *
     * @return boolean
     */
    function getBindRequiresDn();

    /**
     * Returns the base dn where
     *
     * @return string
     */
    function getBaseDn();

    /**
     * Returns true if empty passwords are allowed
     *
     * @return boolean
     */
    function getAllowEmptyPassword();

    /**
     * Returns true if a connection must use start tls
     *
     * @return boolean
     */
    function getUseStartTls();
}
