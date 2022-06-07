<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model;

/**
 * Get current sources
 */
class GetCurrentSources
{
    /**
     * Current stock provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentStockProviderInterface
     */
    private $currentStockProvider;

    /**
     * Get enabled sources by stock ID
     * 
     * @var \Ambros\InventoryCommon\Model\GetEnabledSourcesByStockId 
     */
    private $getEnabledSourcesByStockId;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\CurrentStockProviderInterface $currentStockProvider
     * @param \Ambros\InventoryCommon\Model\GetEnabledSourcesByStockId $getEnabledSourcesByStockId
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\CurrentStockProviderInterface $currentStockProvider,
        \Ambros\InventoryCommon\Model\GetEnabledSourcesByStockId $getEnabledSourcesByStockId
    )
    {
        $this->currentStockProvider = $currentStockProvider;
        $this->getEnabledSourcesByStockId = $getEnabledSourcesByStockId;
    }
    
    /**
     * Execute
     * 
     * @param int|null $storeId
     * @return \Magento\InventoryApi\Api\Data\SourceInterface[]
     */
    public function execute(int $storeId = null): array
    {
        return $this->getEnabledSourcesByStockId->execute($this->currentStockProvider->getId($storeId));
    }
}