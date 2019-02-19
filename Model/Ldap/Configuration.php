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

use Magenerds\Ldap\Api\ConfigInterface;
use Magento\Framework\App\DeploymentConfig;

/**
 * Class Configuration
 *
 * @package Magenerds\Ldap\Model\Ldap
 */
class Configuration implements ConfigInterface
{
    /**
     * @var DeploymentConfig
     */
    private $deploymentConfig;

    /**
     * Configuration constructor.
     * @param DeploymentConfig $deploymentConfig
     */
    public function __construct(
        DeploymentConfig $deploymentConfig
    )
    {
        $this->deploymentConfig = $deploymentConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserFilter()
    {

        return $this->deploymentConfig->get(
            ConfigInterface::CONFIG_KEY_USER_FILTER,
            ConfigInterface::DEFAULT_USER_FILTER
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getCachePassword()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_CACHE_PASSWORD);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeNameUsername()
    {
        return $this->deploymentConfig->get(
            ConfigInterface::CONFIG_KEY_ATTRIBUTE_USERNAME,
            ConfigInterface::DEFAULT_ATTRIBUTE_USERNAME
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeNameFirstName()
    {
        return $this->deploymentConfig->get(
            ConfigInterface::CONFIG_KEY_ATTRIBUTE_FIRST_NAME,
            ConfigInterface::DEFAULT_ATTRIBUTE_FIRST_NAME
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeNameLastName()
    {
        return $this->deploymentConfig->get(
            ConfigInterface::CONFIG_KEY_ATTRIBUTE_LAST_NAME,
            ConfigInterface::DEFAULT_ATTRIBUTE_LAST_NAME
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultRoleId()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_ROLE);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeNameEmail()
    {
        return $this->deploymentConfig->get(
            ConfigInterface::CONFIG_KEY_ATTRIBUTE_EMAIL,
            ConfigInterface::DEFAULT_ATTRIBUTE_EMAIL
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeNameRole()
    {
        return $this->deploymentConfig->get(
            ConfigInterface::CONFIG_KEY_ATTRIBUTE_ROLE,
            ConfigInterface::DEFAULT_ATTRIBUTE_ROLE
        );
    }

    /**
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_HOST);
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return $this->deploymentConfig->get(
            ConfigInterface::CONFIG_KEY_PORT,
            ConfigInterface::DEFAULT_PORT
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getUseSsl()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_USE_SSL);
    }

    /**
     * {@inheritdoc}
     */
    public function getBindDn()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_BIND_DN);
    }

    /**
     * {@inheritdoc}
     */
    public function getBindPassword()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_BIND_PASSWORD);
    }

    /**
     * {@inheritdoc}
     */
    public function getBindRequiresDn()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_BIND_REQUIRES_DN);
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseDn()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_BASE_DN);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowEmptyPassword()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_ALLOW_EMPTY_PASSWORD);
    }

    /**
     * {@inheritdoc}
     */
    public function getUseStartTls()
    {
        return $this->deploymentConfig->get(ConfigInterface::CONFIG_KEY_USE_TLS);
    }
}
