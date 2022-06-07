<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryDistanceBasedSourceSelection\Algorithms;

/**
 * Distance based source selection algorithm plugin
 */
class DistanceBasedAlgorithm extends \Ambros\Common\Plugin\Plugin 
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
     * @param \Magento\InventoryDistanceBasedSourceSelection\Model\Algorithms\DistanceBasedAlgorithm $subject
     * @param \Closure $proceed
     * @param \Magento\InventorySourceSelectionApi\Api\Data\InventoryRequestInterface $inventoryRequest
     * @return \Magento\InventorySourceSelectionApi\Api\Data\SourceSelectionResultInterface
     */
    public function aroundExecute(
        $subject,
        \Closure $proceed,
        \Magento\InventorySourceSelectionApi\Api\Data\InventoryRequestInterface $inventoryRequest
    ) : \Magento\InventorySourceSelectionApi\Api\Data\SourceSelectionResultInterface
    {
        $this->setSubject($subject);
        $destinationAddress = $inventoryRequest->getExtensionAttributes()->getDestinationAddress();
        if ($destinationAddress === null) {
            throw new \Magento\Framework\Exception\LocalizedException(__('No destination address was provided in the request'));
        }
        $sortedSources = $this->invokeSubjectMethod('getEnabledSourcesOrderedByDistanceByStockId', $inventoryRequest->getStockId(), $destinationAddress);
        return $this->getDefaultSortedSourcesResult->execute($inventoryRequest, $sortedSources);
    }
}