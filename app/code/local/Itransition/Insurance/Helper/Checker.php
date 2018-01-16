<?php
    /**
     * Created by PhpStorm.
     * User: igor
     * Date: 02/01/2018
     * Time: 15:26
     */

    class Itransition_Insurance_Helper_Checker extends Mage_Core_Helper_Abstract
    {
        /**
         * @return bool
         */
        public function is_module_active()
        {
            $storeConfig = Mage::getStoreConfig('shipping');
            return Mage::getStoreConfigFlag('shipping/option/shipping_includes_insurance');
        }
    }
