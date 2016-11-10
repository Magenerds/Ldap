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
namespace Magenerds\Ldap\Api;


use Zend_Ldap_Collection;

/**
 * Interface LdapClientInterface
 * @package Magenerds\Ldap\Api
 */
interface LdapClientInterface
{
    /**
     *
     * @return boolean true if ldap is connected otherwise false
     */
    function canBind();

    /**
     * A global LDAP search routine for finding information of a user.
     *
     * @param $username
     *
     * @return Zend_Ldap_Collection
     */
    function getUserByUsername($username);
}
