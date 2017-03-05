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
 * @copyright  Copyright (c) 2017 TechDivision GmbH (http://www.techdivision.com)
 * @link       http://www.techdivision.com/
 * @link       https://github.com/Magenerds/Ldap
 * @author     Julian Schlarb <j.schlarb@techdivision.com>
 */
namespace Magenerds\Ldap\Model\Ldap;

use Exception;
use Magenerds\Ldap\Api\LdapClientInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Zend_Ldap;
use Zend_Ldap_Exception;

/**
 * Class LdapClient
 *
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

    /**
     * {@inheritdoc}
     */
    public function getUserByUsername($username)
    {
        $this->bind();

        $params = [
            ':username' => $username,
            ':usernameAttribute' => $this->configuration->getAttributeNameUsername()
        ];

        $query = strtr($this->configuration->getUserFilter(), $params);

        try {
            return $this->ldap->search($query, null, Zend_Ldap::SEARCH_SCOPE_ONE);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new LocalizedException(__('Login temporary deactivated. Check your logs for more Information.'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bind()
    {
        if ($this->ldap === null) {
            $this->ldap = new Zend_Ldap($this->configuration->getLdapConnectionOptions());
            $this->ldap->bind();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function canBind()
    {
        try {
            $this->bind();
        } catch (Zend_Ldap_Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }

        return true;
    }
}
