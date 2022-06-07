<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventorySourceSelection\Algorithms\Result;

/**
 * Get default sorted sources result plugin
 */
class GetDefaultSortedSourcesResult
{
    /**
     * Order item repository
     * 
     * @var \Ambros\Inventory\Model\InventorySourceSelection\Algorithms\Result\GetDefaultSortedSourcesResult
     */
    private $getDefaultSortedSourcesResult;

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\InventorySourceSelection\Algorithms\Result\GetDefaultSortedSourcesResult $getDefaultSortedSourcesResult
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\InventorySourceSelection\Algorithms\Result\GetDefaultSortedSourcesResult $getDefaultSortedSourcesResult
    )
    {
        $this->getDefaultSortedSourcesResult = $getDefaultSortedSourcesResult;
    }
    
    /**
     * Around execute
     * 
     * @param \Magento\InventorySourceSelectionApi\Model\Algorithms\Result\GetDefaultSortedSourcesResult
     * @param \Closure $proceed
     * @param \Magento\InventorySourceSelectionApi\Api\Data\InventoryRequestInterface $inventoryRequest
     * @param \Magento\InventoryApi\Api\Data\SourceInterface[] $sortedSources
     * @return \Magento\InventorySourceSelectionApi\Api\Data\SourceSelectionResultInterface
     */
    public function aroundExecute(
        \Magento\InventorySourceSelectionApi\Model\Algorithms\Result\GetDefaultSortedSourcesResult $subject,
        \Closure $proceed,
        \Magento\InventorySourceSelectionApi\Api\Data\InventoryRequestInterface $inventoryRequest,
        array $sortedSources
    ): \Magento\InventorySourceSelectionApi\Api\Data\SourceSelectionResultInterface
    {
        return $this->getDefaultSortedSourcesResult->execute($inventoryRequest, $sortedSources);
    }
}