<?php
	/**
	 * Created by PhpStorm.
	 * User: igor
	 * Date: 26.12.17
	 * Time: 13:13
	 */
	
	class Itransition_Insurance_Model_Insurance extends Mage_Shipping_Model_Shipping
	{
        public function toOptionArray()
        {
            return [
                'absolute' => 'absolute',
                'percentage' => 'percentage'
            ];
	    }
	}