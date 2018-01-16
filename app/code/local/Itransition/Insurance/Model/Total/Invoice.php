<?php
    
    /**
     * Class Itransition_Insurance_Model_Total_Invoice
     */
    class Itransition_Insurance_Model_Total_Invoice extends Mage_Sales_Model_Order_Invoice_Total_Abstract
    {
        public function collect(Mage_Sales_Model_Order_Invoice $invoice)
        {
            $order = $invoice->getOrder();
            
            if ($amount = $order->getShippingAddress()->getInsuranceAmount()) {
                $invoice->setGrandTotal($invoice->getGrandTotal() + $amount);
                $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $amount);
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