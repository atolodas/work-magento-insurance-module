<?php
    
    /**
     * Class Itransition_Insurance_Model_Total_Creditmemo
     */
    class Itransition_Insurance_Model_Total_Creditmemo extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
    {
        public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
        {
            $order = $creditmemo->getOrder();
            
            if ($amount = $order->getShippingAddress()->getInsuranceAmount()) {
                $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $amount);
                $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $amount);
            }
            
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