<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @package    Magenerds_Smtp
 * @subpackage Setup
 * @copyright  Copyright (c) 2017 TechDivision GmbH (http://www.techdivision.com)
 * @version    ${release.version}
 * @link       http://www.techdivision.com/
 * @author     Julian Schlarb <j.schlarb@techdivision.com>
 */
namespace Magenerds\Ldap\Setup;

use Magenerds\Ldap\Api\ConfigInterface;
use Magento\Authorization\Model\Role;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Config\Data\ConfigData;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Setup\ConfigOptionsListInterface;
use Magento\Framework\Setup\Option\AbstractConfigOption;
use Magento\Framework\Setup\Option\FlagConfigOption;
use Magento\Framework\Setup\Option\SelectConfigOption;
use Magento\Framework\Setup\Option\TextConfigOption;

/**
 * Class ConfigOptionsList
 * @category   Magenerds
 */
class ConfigOptionsList implements ConfigOptionsListInterface
{
    /**
     * Input key for the options
     */
    const INPUT_KEY_HOST = 'ldap-host';
    const INPUT_KEY_PORT = 'ldap-port';
    const INPUT_KEY_USE_TLS = 'ldap-use-tls';
    const INPUT_KEY_USE_SSL = 'ldap-use-ssl';
    const INPUT_KEY_BIND_REQUIRES_DN = 'ldap-bind-requires-dn';
    const INPUT_KEY_BASE_DN = 'ldap-base-dn';
    const INPUT_KEY_BIND_DN = 'ldap-bind-dn';
    const INPUT_KEY_BIND_PASSWORD = 'ldap-bind-password'; //NOSONAR
    const INPUT_KEY_ALLOW_EMPTY_PASSWORD = 'ldap-allow-empty-password'; //NOSONAR
    const INPUT_KEY_CACHE_PASSWORD = 'ldap-cache-password'; //NOSONAR
    const INPUT_KEY_ROLE = 'ldap-role';
    const INPUT_KEY_USER_FILTER = 'ldap-user-filter';
    const INPUT_KEY_ATTRIBUTE_USERNAME = 'ldap-attribute-username';
    const INPUT_KEY_ATTRIBUTE_FIRST_NAME = 'ldap-attribute-first-name';
    const INPUT_KEY_ATTRIBUTE_LAST_NAME = 'ldap-attribute-last-name';
    const INPUT_KEY_ATTRIBUTE_EMAIL = 'ldap-attribute-email';
    const INPUT_KEY_ATTRIBUTE_ROLE = 'ldap-attribute-role';

    /**
     * @var Role
     */
    private $role;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * ConfigOptionsList constructor.
     * @param ObjectManagerInterface $objectManager
     * @param Role $role
     */
    public function __construct(ObjectManagerInterface $objectManager, Role $role)
    {
        $this->role = $role;
        $this->objectManager = $objectManager;
    }

    /**
     * Gets a list of input options so that user can provide required
     * information that will be used in deployment config file
     *
     * @return AbstractConfigOption[]
     */
    public function getOptions()
    {
        return [
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_HOST,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_HOST,
                'Ldap host'
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_PORT,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_PORT,
                'Ldap Port',
                ConfigInterface::DEFAULT_PORT
            ),
            new FlagConfigOption(
                ConfigOptionsList::INPUT_KEY_USE_TLS,
                ConfigInterface::CONFIG_KEY_USE_TLS,
                'For the sake of security, this should be `yes` if the server has the necessary certificate installed.'
            ),
            new FlagConfigOption(
                ConfigOptionsList::INPUT_KEY_USE_SSL,
                ConfigInterface::CONFIG_KEY_USE_SSL,
                'Possibly used as an alternative to useStartTls'
            ),
            new FlagConfigOption(
                ConfigOptionsList::INPUT_KEY_BIND_REQUIRES_DN,
                ConfigInterface::CONFIG_KEY_BIND_REQUIRES_DN,
                'As OpenLDAP requires that usernames be in DN form when performing a bind.'
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_BASE_DN,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_BASE_DN,
                'As with all servers, this option is required and indicates the DN under which all accounts being authenticated are located.'
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_BIND_DN,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_BIND_DN,
                'Required and must be a DN, as OpenLDAP requires that usernames be in DN form when performing a bind. Try to use an unprivileged account.'
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_BIND_PASSWORD,
                TextConfigOption::FRONTEND_WIZARD_PASSWORD,
                ConfigInterface::CONFIG_KEY_BIND_PASSWORD,
                'The password corresponding to the username above, but this may be omitted if the LDAP server permits an anonymous binding to query user accounts.'
            ),
            new FlagConfigOption(
                ConfigOptionsList::INPUT_KEY_ALLOW_EMPTY_PASSWORD,
                ConfigInterface::CONFIG_KEY_ALLOW_EMPTY_PASSWORD,
                'Allow empty password'
            ),
            new FlagConfigOption(
                ConfigOptionsList::INPUT_KEY_CACHE_PASSWORD,
                ConfigInterface::CONFIG_KEY_CACHE_PASSWORD,
                'To save the user password in the Magento database. Then, users will be able to log in even when the LDAP server is not reachable.'
            ),
            new SelectConfigOption(
                ConfigOptionsList::INPUT_KEY_ROLE,
                SelectConfigOption::FRONTEND_WIZARD_RADIO,
                $this->getRoleNames(),
                ConfigInterface::CONFIG_KEY_ROLE,
                'Role that assigned to a user on first login'
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_USER_FILTER,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_USER_FILTER,
                'Ldap search filter. Placeholders are ":usernameAttribute" and ":username"',
                ConfigInterface::DEFAULT_USER_FILTER
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_ATTRIBUTE_USERNAME,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_ATTRIBUTE_USERNAME,
                'Attribute in LDAP defining the user’s username.',
                ConfigInterface::DEFAULT_ATTRIBUTE_USERNAME
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_ATTRIBUTE_FIRST_NAME,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_ATTRIBUTE_FIRST_NAME,
                'Attribute in LDAP defining the user’s first name.',
                ConfigInterface::DEFAULT_ATTRIBUTE_FIRST_NAME
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_ATTRIBUTE_LAST_NAME,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_ATTRIBUTE_LAST_NAME,
                'Attribute in LDAP defining the user’s last name.',
                ConfigInterface::DEFAULT_ATTRIBUTE_LAST_NAME
            ),
            new TextConfigOption(
                ConfigOptionsList::INPUT_KEY_ATTRIBUTE_EMAIL,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                ConfigInterface::CONFIG_KEY_ATTRIBUTE_EMAIL,
                'Attribute in LDAP defining the user’s email.',
                ConfigInterface::DEFAULT_ATTRIBUTE_EMAIL
            ),
        ];
    }

    /**
     * Creates array of ConfigData objects from user input data.
     * Data in these objects will be stored in array form in deployment config file.
     *
     * @param array $options
     * @param DeploymentConfig $deploymentConfig
     * @return \Magento\Framework\Config\Data\ConfigData[]
     */
    public function createConfig(array $options, DeploymentConfig $deploymentConfig)
    {
        $configData = new ConfigData(ConfigFilePool::APP_ENV);

        $textConfig = [
            ConfigOptionsList::INPUT_KEY_HOST => ConfigInterface::CONFIG_KEY_HOST,
            ConfigOptionsList::INPUT_KEY_PORT => ConfigInterface::CONFIG_KEY_PORT,
            ConfigOptionsList::INPUT_KEY_BASE_DN => ConfigInterface::CONFIG_KEY_BASE_DN,
            ConfigOptionsList::INPUT_KEY_BIND_DN => ConfigInterface::CONFIG_KEY_BIND_DN,
            ConfigOptionsList::INPUT_KEY_BIND_PASSWORD => ConfigInterface::CONFIG_KEY_BIND_PASSWORD,
            ConfigOptionsList::INPUT_KEY_USER_FILTER => ConfigInterface::CONFIG_KEY_USER_FILTER,
            ConfigOptionsList::INPUT_KEY_ATTRIBUTE_USERNAME => ConfigInterface::CONFIG_KEY_ATTRIBUTE_USERNAME,
            ConfigOptionsList::INPUT_KEY_ATTRIBUTE_FIRST_NAME => ConfigInterface::CONFIG_KEY_ATTRIBUTE_FIRST_NAME,
            ConfigOptionsList::INPUT_KEY_ATTRIBUTE_LAST_NAME => ConfigInterface::CONFIG_KEY_ATTRIBUTE_LAST_NAME,
            ConfigOptionsList::INPUT_KEY_ATTRIBUTE_EMAIL => ConfigInterface::CONFIG_KEY_ATTRIBUTE_EMAIL,
            ConfigOptionsList::INPUT_KEY_ATTRIBUTE_ROLE => ConfigInterface::CONFIG_KEY_ATTRIBUTE_ROLE,
        ];

        $flagConfig = [
            ConfigOptionsList::INPUT_KEY_ALLOW_EMPTY_PASSWORD => ConfigInterface::CONFIG_KEY_ALLOW_EMPTY_PASSWORD,
            ConfigOptionsList::INPUT_KEY_CACHE_PASSWORD => ConfigInterface::CONFIG_KEY_CACHE_PASSWORD,
            ConfigOptionsList::INPUT_KEY_USE_TLS => ConfigInterface::CONFIG_KEY_USE_TLS,
            ConfigOptionsList::INPUT_KEY_USE_SSL => ConfigInterface::CONFIG_KEY_USE_SSL,
            ConfigOptionsList::INPUT_KEY_BIND_REQUIRES_DN => ConfigInterface::CONFIG_KEY_BIND_REQUIRES_DN,
        ];

        if (isset($options[ConfigOptionsList::INPUT_KEY_ROLE])) {
            $configData->set(
                ConfigInterface::CONFIG_KEY_ROLE,
                $this->getRoleIdByName($options[ConfigOptionsList::INPUT_KEY_ROLE])
            );
        }

        foreach ($textConfig as $inputKey => $configKey) {
            if (isset($options[$inputKey])) {
                $configData->set(
                    $configKey,
                    $options[$inputKey]
                );
            }
        }

        foreach ($flagConfig as $inputKey => $configKey) {
            if (isset($options[$inputKey])) {
                $configData->set(
                    $configKey,
                    $options[$inputKey]
                );
            }
        }

        return [$configData];
    }

    /**
     * Returns a list of role names
     *
     * @return string[]
     */
    protected function getRoleNames()
    {
        $roles = $this->role->getCollection();

        $result = [];

        /** @var Role $role */
        foreach ($roles as $role) {
            $result[] = $role->getRoleName();
        }

        return $result;
    }

    /**
     * Returns the role id for a given name
     *
     * @param string $roleName
     * @return integer
     */
    protected function getRoleIdByName($roleName)
    {
        // RoleFactory is not present during setup:upgrade
        /** @var Role $role */
        $role = $this->objectManager->create(Role::class)->load($roleName, 'role_name');

        return $role->getId();
    }

    /**
     * Validates user input option values and returns error messages
     *
     * @param array $options
     * @param DeploymentConfig $deploymentConfig
     * @return string[]
     */
    public function validate(array $options, DeploymentConfig $deploymentConfig)
    {
        return [];
    }
}
