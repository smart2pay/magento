<?php
class Smart2Pay_Globalpay_Block_Sales_Order_Total extends Mage_Core_Block_Template
{
    /**
     * Get label cell tag properties
     *
     * @return string
     */
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * Get order store object
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * Get totals source object
     *
     * @return Mage_Sales_Model_Order
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * Get value cell tag properties
     *
     * @return string
     */
    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * Initialize reward points totals
     *
     * @return Smart2Pay_Globalpay_Block_Sales_Order_Total
     */
    public function initTotals()
    {
        if( ($payment_obj = $this->getOrder()->getPayment())
        and (float)$payment_obj->getS2pSurchargeAmount() != 0 )
        {
            /** @var Smart2Pay_Globalpay_Helper_Helper $helper_obj */
            $helper_obj = Mage::helper('globalpay/helper');

            //$source = $this->getSource();
            $amount = $payment_obj->getS2pSurchargeAmount();
            $base_amount = $payment_obj->getS2pSurchargeBaseAmount();
            $percent = $payment_obj->getS2pSurchargePercent();

            $this->getParentBlock()->addTotal(new Varien_Object(array(
                'code'   => 'globalpay',
                'strong' => false,
                'label'  => $helper_obj->format_surcharge_label( $amount, $percent ),
                'value'  => $helper_obj->format_surcharge_value( $amount, $percent ),
                'base_value'  => $helper_obj->format_surcharge_value( $base_amount, $percent ),
                'area'  => 'footer',
            )));
        }

        return $this;
    }
}
