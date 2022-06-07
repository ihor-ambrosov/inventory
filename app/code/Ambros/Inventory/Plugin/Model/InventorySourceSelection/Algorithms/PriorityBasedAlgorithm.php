<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventorySourceSelection\Algorithms;

/**
 * Priority based source selection algorithm plugin
 */
class PriorityBasedAlgorithm extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Get default sorted sources result
     * 
     * @var \Ambros\Inventory\Model\InventorySourceSelection\Algorithms\Result\GetDefaultSortedSourcesResult 
     */
    private $getDefaultSortedSourcesResult;
    
    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\Inventory\Model\InventorySourceSelection\Algorithms\Result\GetDefaultSortedSourcesResult $getDefaultSortedSourcesResult
     * @retun void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Model\InventorySourceSelection\Algorithms\Result\GetDefaultSortedSourcesResult $getDefaultSortedSourcesResult
    )
    {
        parent::__construct($wrapperFactory);
        $this->getDefaultSortedSourcesResult = $getDefaultSortedSourcesResult;
    }
    
    /**
     * Around execute
     * 
     * @param \Magento\InventorySourceSelection\Model\Algorithms\PriorityBasedAlgorithm
     * @param \Closure $proceed
     * @return \Magento\InventorySourceSelectionApi\Api\Data\SourceSelectionResultInterface
     */
    public function aroundExecute(
        \Magento\InventorySourceSelection\Model\Algorithms\PriorityBasedAlgorithm $subject,
        \Closure $proceed,
        \Magento\InventorySourceSelectionApi\Api\Data\InventoryRequestInterface $inventoryRequest
    ) : \Magento\InventorySourceSelectionApi\Api\Data\SourceSelectionResultInterface
    {
        $this->setSubject($subject);
        $sortedSources = $this->invokeSubjectMethod('getEnabledSourcesOrderedByPriorityByStockId', $inventoryRequest->getStockId());
        return $this->getDefaultSortedSourcesResult->execute($inventoryRequest, $sortedSources);
    }
}