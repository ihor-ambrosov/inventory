<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Quote\ResourceModel\Quote\Address;

/**
 * Quote address rate resource plugin
 */
class Rate extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Before get main table
     * 
     * @param \Magento\Quote\Model\ResourceModel\Quote\Address\Rate $subject
     * @return void
     */
    public function beforeGetMainTable(\Magento\Quote\Model\ResourceModel\Quote\Address\Rate $subject)
    {
        $this->setSubject($subject);
        $this->invokeSubjectMethod('_setMainTable', 'ambros_inventory__source_quote_shipping_rate', 'rate_id');
    }
}