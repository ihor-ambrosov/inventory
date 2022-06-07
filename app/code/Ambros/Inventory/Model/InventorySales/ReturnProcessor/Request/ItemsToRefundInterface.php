<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales\ReturnProcessor\Request;

/**
 * Items to refund return processor request interface
 */
interface ItemsToRefundInterface extends \Magento\InventorySalesApi\Model\ReturnProcessor\Request\ItemsToRefundInterface
{
    /**
     * Get source code
     * 
     * @return string
     */
    public function getSourceCode(): string;
}