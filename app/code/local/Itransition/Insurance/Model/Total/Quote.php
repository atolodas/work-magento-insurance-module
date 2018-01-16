<?php
    
    /**
     * Class Itransition_Insurance_Model_Total_Order
     */
    class Itransition_Insurance_Model_Total_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
    {
        public function collect(Mage_Sales_Model_Quote_Address $address)
        {
            $amount = $address->getInsuranceAmount();
            parent::collect($address);
            $address->setInsuranceAmount($amount);
            $this->_addAmount($amount);
            $this->_addBaseAmount($amount);
            
            return $this;
        }
    
        public function fetch(Mage_Sales_Model_Quote_Address $address)
        {
            if ($address->getAddressType() == $address::TYPE_SHIPPING) {
                $amount = $address->getQuote()->getShippingAddress()->getInsuranceAmount();
    
                if ($amount) {
                    $address->addTotal([
                        'code'      => 'insurance',
                        'value'     => $amount,
                        'title'     => 'Insurance amount',
                    ]);
                }
            }
        
            return $this;
        }
    }