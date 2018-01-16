<?php
    /**
     * Created by PhpStorm.
     * User: igor
     * Date: 27.12.17
     * Time: 18:06
     */
    
    /**
     * Class Itransition_Insurance_Model_Observer_Insurance
     */
    class Itransition_Insurance_Model_Observer_Insurance
    {
        public function extendCarrierConfig(Varien_Event_Observer $observer)
        {
            $main_config = Mage::getConfig();
            $system_config = $observer->getConfig();
            $include_insurance_xml = $main_config->getNode('insurance/carrier/fields');
            // If Include Insurance for Shipping on the System/Configuration/Shipping Settings page is on, add necessary fields to every shipping method on System/Configuration/Shipping Methods page.
            if (Mage::helper('itransition_insurance/checker')->is_module_active()) {
                $carriers = $system_config->getNode('sections/carriers/groups');
                if (!empty($carriers)) {
                    /** @var Mage_Core_Model_Config_Element $carrier */
                    foreach ($carriers->children() as $carrier) {
                        $carrier->descend('fields')->extend($include_insurance_xml);
                    }
                }
            }
        }
    
        public function addInsurance(Varien_Event_Observer $observer)
        {
            $data = $observer->getData();
            // Here we set the insurance fields
            $onepage_model = $this->getOnepage();
            $onepage_model->saveInsurance($data);
            
            return true;
        }
    
        /**
         * Get one page checkout model
         *
         * @return Itransition_Insurance_Model_Onepage
         */
        public function getOnepage()
        {
            return Mage::getSingleton('insurance/onepage');
        }
    }
