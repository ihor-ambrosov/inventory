<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\OfflineShipping\ResourceModel\Carrier;

/**
 * Shipping table rate resource plugin
 */
class Tablerate extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Before get main table
     * 
     * @param \Magento\OfflineShipping\Model\ResourceModel\Carrier\Tablerate $subject
     * @return void
     */
    public function beforeGetMainTable(\Magento\OfflineShipping\Model\ResourceModel\Carrier\Tablerate $subject)
    {
        $this->setSubject($subject);
        $this->invokeSubjectMethod('_setMainTable', 'ambros_inventory__source_shipping_tablerate', 'pk');
    }
}