<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Ui\InventoryShipping\DataProvider;

/**
 * Get source selection data provider sources
 */
class GetSources
{
    /**
     * Get source by source code
     * 
     * @var \Ambros\InventoryCommon\Model\GetSourceBySourceCode
     */
    private $getSourceBySourceCode;
    
    /**
     * Item request factory
     * 
     * @var \Magento\InventorySourceSelectionApi\Api\Data\ItemRequestInterfaceFactory
     */
    protected $itemRequestFactory;
    
    /**
     * Source selection service
     * 
     * @var \Magento\InventorySourceSelectionApi\Api\SourceSelectionServiceInterface
     */
    protected $sourceSelectionService;
    
    /**
     * Get default source selection algorithm code
     * 
     * @var \Magento\InventorySourceSelectionApi\Api\GetDefaultSourceSelectionAlgorithmCodeInterface
     */
    protected $getDefaultSourceSelectionAlgorithmCode;
    
    /**
     * Get inventory request from order
     * 
     * @var \Ambros\Inventory\Model\InventorySourceSelection\GetInventoryRequestFromOrder 
     */
    protected $getInventoryRequestFromOrder;
    
    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode
     * @param \Magento\InventorySourceSelectionApi\Api\Data\ItemRequestInterfaceFactory $itemRequestFactory
     * @param \Magento\InventorySourceSelectionApi\Api\SourceSelectionServiceInterface $sourceSelectionService
     * @param \Magento\InventorySourceSelectionApi\Api\GetDefaultSourceSelectionAlgorithmCodeInterface $getDefaultSourceSelectionAlgorithmCode
     * @param \Ambros\Inventory\Model\InventorySourceSelection\GetInventoryRequestFromOrder $getInventoryRequestFromOrder
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode,
        \Magento\InventorySourceSelectionApi\Api\Data\ItemRequestInterfaceFactory $itemRequestFactory,
        \Magento\InventorySourceSelectionApi\Api\SourceSelectionServiceInterface $sourceSelectionService,
        \Magento\InventorySourceSelectionApi\Api\GetDefaultSourceSelectionAlgorithmCodeInterface $getDefaultSourceSelectionAlgorithmCode,
        \Ambros\Inventory\Model\InventorySourceSelection\GetInventoryRequestFromOrder $getInventoryRequestFromOrder
    )
    {
        $this->getSourceBySourceCode = $getSourceBySourceCode;
        $this->itemRequestFactory = $itemRequestFactory;
        $this->sourceSelectionService = $sourceSelectionService;
        $this->getDefaultSourceSelectionAlgorithmCode = $getDefaultSourceSelectionAlgorithmCode;
        $this->getInventoryRequestFromOrder = $getInventoryRequestFromOrder;
    }
    
    /**
     * Execute
     * 
     * @param int $orderId
     * @param int $orderItemId
     * @param string $sku
     * @param float $qty
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(int $orderId, int $orderItemId, string $sku, float $qty): array
    {
        $itemRequest = $this->itemRequestFactory->create(['sku' => $sku, 'qty' => $qty]);
        $itemRequest->getExtensionAttributes()->setOrderItemId($orderItemId);
        $inventoryRequest = $this->getInventoryRequestFromOrder->execute($orderId, [$itemRequest]);
        $sourceSelectionResult = $this->sourceSelectionService->execute(
            $inventoryRequest,
            $this->getDefaultSourceSelectionAlgorithmCode->execute()
        );
        $result = [];
        foreach ($sourceSelectionResult->getSourceSelectionItems() as $item) {
            $sourceCode = (string) $item->getSourceCode();
            $source = $this->getSourceBySourceCode->execute($sourceCode);
            $result[] = [
                'sourceName' => $source ? $source->getName() : $sourceCode,
                'sourceCode' => $sourceCode,
                'qtyAvailable' => $item->getQtyAvailable(),
                'qtyToDeduct' => $item->getQtyToDeduct(),
            ];
        }
        return $result;
    }
}