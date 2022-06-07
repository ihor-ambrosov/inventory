<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales\ReturnProcessor\Request;

/**
 * Items to refund return processor request
 */
class ItemsToRefund extends \Magento\InventorySales\Model\ReturnProcessor\Request\ItemsToRefund 
    implements \Ambros\Inventory\Model\InventorySales\ReturnProcessor\Request\ItemsToRefundInterface 
{
    /**
     * Source code
     * 
     * @var string
     */
    private $sourceCode;

    /**
     * Constructor
     * 
     * @param string $sku
     * @param string $sourceCode
     * @param float $qty
     * @param float $processedQty
     * @return void
     */
    public function __construct(string $sku, string $sourceCode, float $qty, float $processedQty)
    {
        parent::__construct($sku, $qty, $processedQty);
        $this->sourceCode = $sourceCode;
    }

    /**
     * Get source code
     * 
     * @return string
     */
    public function getSourceCode(): string
    {
        return $this->sourceCode;
    }
}