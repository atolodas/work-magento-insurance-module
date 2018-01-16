<?php
    
     function setupInsuranceDatabase(Mage_Core_Model_Resource_Setup $setup) {
        
        // Table to include columns into
        $tables = [
            $setup->getTable('sales_flat_order_address'),
            $setup->getTable('sales_flat_quote_address'),
        ];
        
        $setup->startSetup();
        
        $db_connection = $setup->getConnection();
    
        
        foreach ($tables as $table) {
            if (!$db_connection->tableColumnExists($table, 'is_include_insurance')) {
                $db_connection->addColumn($table, 'is_include_insurance', [
                    'type'      => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
                    'nullable'  => false,
                    'default'   => 0,
                    'comment'   => 'Is insurance included'
                ]);
            }
            
            if (!$db_connection->tableColumnExists($table, 'insurance_amount')) {
                $db_connection->addColumn($table, 'insurance_amount', [
                    'type'      => Varien_Db_Ddl_Table::TYPE_DECIMAL,
                    'scale'     => 4,
                    'precision' => 12,
                    'nullable'  => false,
                    'default'   => '0.00',
                    'comment'   => 'Insurance amount'
                ]);
            }
        }
        
        $setup->endSetup();
    };

    // Creating DB fields
    setupInsuranceDatabase($this);
