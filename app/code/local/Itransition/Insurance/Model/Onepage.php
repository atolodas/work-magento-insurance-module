<?php
    /**
     * Created by PhpStorm.
     * User: igor
     * Date: 26.12.17
     * Time: 13:13
     */
    
    class Itransition_Insurance_Model_Onepage extends Mage_Checkout_Model_Type_Onepage
    {
        public function saveInsurance($data)
        {
            if ($include_insurance = $data['request']->getPost('include_insurance')) {
    
                /** @var Mage_Sales_Model_Quote $quote */
                // $quote = $data['quote'];
                $quote = $this->getQuote();
                /** @var Mage_Sales_Model_Quote_Address $shipping_address */
                $shipping_address = $quote->getShippingAddress();
                $shipping_address->setIsIncludeInsurance(1);
                $insurance_amount = $this->calculateInsuranceAmount($shipping_address);
                $shipping_address->setInsuranceAmount($insurance_amount);
                
                return true;
            }
            
            return false;
        }
        
        private function calculateInsuranceAmount(Mage_Sales_Model_Quote_Address $shipping_address)
        {
            $carrier_code = $shipping_address->getShippingMethod();
            $carrier_name = substr($carrier_code, 0, strpos($carrier_code, "_"));
            $carrier_data = Mage::getStoreConfig('carriers/' . $carrier_name);
            $insurance_type = $carrier_data['insurance_type'];
            $insurance_amount = (float)$carrier_data['insurance_value'];
            if ($insurance_type === 'percentage') {
                $insurance_amount = ($shipping_address->getSubtotal() / 100) * (float)$insurance_amount;
            }
            
            return $insurance_amount;
        }
    }