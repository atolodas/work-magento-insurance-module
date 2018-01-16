<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2017 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml order creditmemo totals block
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Itransition_Insurance_Sales_Block_Order_Invoice_Totals extends Mage_Sales_Block_Order_Invoice_Totals
{
    /**
     * @inheritdoc
     *
     * @return Itransition_Insurance_Sales_Block_Order_Invoice_Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();
        
        $order = $this->getOrder();
        
        if ($order->getShippingAddress()->getIsIncludeInsurance()) {
            
            $amount = $order->getShippingAddress()->getInsuranceAmount();
            
            $this->addTotalBefore(new Varien_Object([
                'code'      => 'insurance',
                'value'     => $amount,
                'label'     => 'Insurance amount',
            ]), 'shipping_and_handling');
            
        }
        
        return $this;
    }
}
