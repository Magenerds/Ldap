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
namespace Magenerds\Ldap\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 *
 * @package Magenerds\Ldap\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws StateException
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (!extension_loaded('ldap')) {
            throw new StateException(__('PHP ldap extension is not present!'));
        }

        $adminUserTableName = $setup->getTable('admin_user');

        $connection = $setup->getConnection();

        $connection->addColumn($adminUserTableName, 'ldap_dn', [
            'type' => Table::TYPE_TEXT,
            'nullable' => true,
            'comment' => 'LDAP user dn',
        ]);

        $setup->endSetup();
    }
}
