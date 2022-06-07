<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales\IsProductSalableForRequestedQtyCondition;

/**
 * Is salable for requested qty abstract condition
 */
abstract class AbstractCondition implements \Ambros\Inventory\Api\InventorySales\IsProductSalableForRequestedQtyInterface 
{
    /**
     * Get stock ID by source code
     * 
     * @var \Ambros\InventoryCommon\Model\GetStockIdBySourceCode 
     */
    protected $getStockIdBySourceCode;
    
    /**
     * Product salability error factory
     * 
     * @var \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory
     */
    protected $productSalabilityErrorFactory;

    /**
     * Product salable result factory
     * 
     * @var \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory
     */
    protected $productSalableResultFactory;
    
    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\GetStockIdBySourceCode $getStockIdBySourceCode
     * @param \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory
     * @param \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory $productSalableResultFactory
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\GetStockIdBySourceCode $getStockIdBySourceCode,
        \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory,
        \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory $productSalableResultFactory
    )
    {
        $this->getStockIdBySourceCode = $getStockIdBySourceCode;
        $this->productSalabilityErrorFactory = $productSalabilityErrorFactory;
        $this->productSalableResultFactory = $productSalableResultFactory;
    }

    /**
     * Create product salability error
     * 
     * @param string $errorCode
     * @param \Magento\Framework\Phrase $errorMessage
     * @return \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterface
     */
    protected function createProductSalabilityError($errorCode, $errorMessage)
    {
        return $this->productSalabilityErrorFactory->create(['code' => $errorCode, 'message' => $errorMessage]);
    }
    
    /**
     * Create product salable result
     * 
     * @param array $errors
     * @return \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterface
     */
    protected function createProductSalableResult($errors)
    {
        return $this->productSalableResultFactory->create(['errors' => $errors]);
    }
}