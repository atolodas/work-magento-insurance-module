<?php

/**
 * One page checkout additional blocks for shipping methods
 *
 * @author      <i.kulebyakin@itransition.com>
 */
class Itransition_Insurance_Checkout_Block_Onepage_Shipping_Method_Additional extends Mage_Checkout_Block_Onepage_Shipping_Method_Additional
{
    public $is_insurance_module_active;
    public $allowed_shipping_method_code_list = [];

    /**
     * Itransition_Checkout_Block_Onepage_Shipping_Method_Additional constructor.
     * @param array $args
     */
    public function __construct(array $args = [])
    {
        $this->is_insurance_module_active = $this->helper('itransition_insurance/checker')->is_module_active();
        parent::__construct($args);
    }
    
    /**
     * Returns an array of insurance-enabled shipping methods' data
     * for current shipping address.
     * The data is used on a template.
     */
    public function getInsuranceEnabledCarrierData() {
    
        $shipping_rates = $this->getQuote()->getShippingAddress()->getGroupedAllShippingRates();
        $carriers = Mage::getStoreConfig('carriers');
        $insurance_enabled_carrier_data = [];
        $current_currency_code = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
        // Checking if Shipping Methods are insurance-enabled
        foreach ($shipping_rates as $carrier_name => $rates) {
            if ($carriers[$carrier_name]['include_insurance'] !== '1') {
                unset($shipping_rates[$carrier_name]);
            } else {
                // Assembling insurance-enabled shipping methods' data
                foreach($rates as $rate) {
                    $insurance_enabled_carrier_data[$rate->getCode()] = [
                        'carrier_name' => $carrier_name,
                        'insurance_type' => $carriers[$carrier_name]['insurance_type'],
                        'insurance_value' => $carriers[$carrier_name]['insurance_value'],
                        'currency_symbol' => $current_currency_code
                    ];
                }
            }
        }
        
        return $insurance_enabled_carrier_data;
    }
}
