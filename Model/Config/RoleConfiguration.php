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
namespace Magenerds\Ldap\Model\Config;


use Magento\Authorization\Model\Role;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class RoleConfiguration
 *
 * @package Magenerds\Ldap\Model\Config
 */
class RoleConfiguration implements ArrayInterface
{
    /**
     * @var Role
     */
    private $role;

    /**
     * Role constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $result = [];

        $roles = $this->role->getCollection();

        /** @var Role $role */
        foreach ($roles as $role) {
            $result[] = ['value' => $role->getId(), 'label' => $role->getRoleName()];
        }

        return $result;
    }
}
