<?php

namespace Smartwave\CustomerAddress\Setup;

use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface {

    private $eavConfig;
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig
    ) {
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        /** @var EavSetup $eavSetup */
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $custom_fields = array(
            'neighborhood' => ['label'=>'Neighborhood', 'type'=>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'position'=>250],
            'exterior_number' => ['label'=>'Exterior Number', 'type'=>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'position'=>251],
            'interior_number' => ['label'=>'Interior Number', 'type'=>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'position'=>252],
            'between_street1' => ['label'=>'Street 1', 'type'=>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'position'=>253],
            'between_street2' => ['label'=>'Street 2', 'type'=>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'position'=>254]
        );

        foreach ($custom_fields as $key=>$value) {
            $eavSetup->addAttribute('customer_address', $key, [
                'type' => 'varchar',
                'input' => 'text',
                'label' => $value['label'],
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'system'=> false,
                'group'=> 'General',
                'global' => true,
                'visible_on_front' => true,
                'position' => $value['position'],
            ]);
            $customAttribute = $this->eavConfig->getAttribute('customer_address', $key);

            $customAttribute->setData(
                'used_in_forms',
                [
                    'adminhtml_customer_address',
                    'adminhtml_customer',
                    'customer_address_edit',
                    'customer_register_address',
                    'customer_address',
                ]
            );
            $customAttribute->save();

            $setup->getConnection()->addColumn(
                $setup->getTable('quote_address'),
                $key,
                [
                    'type' => $value['type'],
                    'length' => 255,
                    'comment' => $value['label']
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_address'),
                $key,
                [
                    'type' => $value['type'],
                    'length' => 255,
                    'comment' => $value['label']
                ]
            );
        }


        $setup->endSetup();
    }

}
