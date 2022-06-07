<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales;

/**
 * Get current salable source items
 */
class GetCurrentSalableSourceItems
{
    /**
     * Current stock provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentStockProviderInterface
     */
    protected $currentStockProvider;
    
    /**
     * Get salable source items
     * 
     * @var \Ambros\Inventory\Model\InventorySales\GetSalableSourceItems
     */
    private $getSalableSourceItems;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\CurrentStockProviderInterface $currentStockProvider
     * @param \Ambros\Inventory\Model\InventorySales\GetSalableSourceItems $getSalableSourceItems
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\CurrentStockProviderInterface $currentStockProvider,
        \Ambros\Inventory\Model\InventorySales\GetSalableSourceItems $getSalableSourceItems
    )
    {
        $this->currentStockProvider = $currentStockProvider;
        $this->getSalableSourceItems = $getSalableSourceItems;
    }

    /**
     * Execute
     * 
     * @param string $sku
     * @param int|null $storeId
     * @return \Ambros\Inventory\Model\InventorySales\SourceItemInterface[]
     */
    public function execute(string $sku, int $storeId = null): array
    {
        $stockId = $this->currentStockProvider->getId($storeId);
        return $this->getSalableSourceItems->execute($sku, $stockId);
    }
}