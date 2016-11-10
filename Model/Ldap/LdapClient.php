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


use Magenerds\Ldap\Api\LdapClientInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Zend_Ldap;
use Zend_Ldap_Collection;
use Zend_Ldap_Exception;

/**
 * Class LdapClient
 * @package Magenerds\Ldap\Model\Ldap
 */
class LdapClient implements LdapClientInterface
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Zend_Ldap
     */
    private $ldap;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LdapClient constructor.
     *
     * @param Configuration $configuration
     * @param LoggerInterface $logger
     */
    public function __construct(Configuration $configuration, LoggerInterface $logger)
    {
        $this->configuration = $configuration;
        $this->logger = $logger;
    }

    private function createLdapInstance()
    {
        if ($this->ldap === null) {
            $this->ldap = new Zend_Ldap($this->configuration->getLdapConnectionOptions());
        }
    }

    /**
     * @throws Zend_Ldap_Exception
     */
    public function bind()
    {
        $this->createLdapInstance();

        $this->ldap->bind();
    }

    /**
     * @param $username
     *
     * @throws LocalizedException
     *
     * @return Zend_Ldap_Collection
     */
    public function getUserByUsername($username)
    {
        if ($this->ldap === null) {
            $this->bind();
        }

        $query = sprintf($this->configuration->getUserFilter(), $username);

        try {
            return $this->ldap->search($query, null, Zend_Ldap::SEARCH_SCOPE_ONE);
        } catch (Zend_Ldap_Exception $e) {
            $this->logger->error($e);
            throw new LocalizedException(__('Login temporary deactivated. Check your logs for more Information.'));
        }
    }

    /**
     * Try to establish a connection to the ldap server
     *
     * @return boolean true if ldap is connected otherwise false
     */
    public function canConnect()
    {
        try {
            $this->createLdapInstance();

            $this->ldap->connect();
        } catch (Zend_Ldap_Exception $e) {
            $this->logger->error($e);
            return false;
        }

        return true;
    }
}
