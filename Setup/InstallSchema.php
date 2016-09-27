<?php
namespace W3D\Exportorders\Setup;
 
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
 
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

         $installer->getConnection()->dropTable($installer->getTable('order_export'));
 
        $table = $setup->getConnection()->newTable(
            $setup->getTable('order_export2')
        )->addColumn(
            'created',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            []
        )->addColumn(
            'modified',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            []
        )->addColumn(
            'processed',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            []
        )->addColumn(
            'OrderID',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
        )->addColumn(
            'Date',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
            null,
            []
        )->addColumn(
            'Fisrtname',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'Lastname',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'Customergroup',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'Street',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'City',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'Country',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'Zip',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'PaymentMethod',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'Email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'Subtotal',
            \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
            null,
            []
        )->addColumn(
            'Discount',
            \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
            null,
            []
        )->addColumn(
            'Tax',
            \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
            null,
            []
        )->addColumn(
            'GrandTotal',
            \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
            null,
            []
        )->setComment(
            'Custom Table'
        );
        $setup->getConnection()->createTable($table);
 
        $setup->endSetup();
    }
}
