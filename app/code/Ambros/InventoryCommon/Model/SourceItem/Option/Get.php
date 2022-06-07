<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\SourceItem\Option;

/**
 * Get source item options
 */
class Get implements \Ambros\InventoryCommon\Api\SourceItem\Option\GetInterface
{
    /**
     * Resource
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Get
     */
    private $resource;

    /**
     * Source item option factory
     * 
     * @var \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory
     */
    private $optionFactory;

    /**
     * Data object helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * Source item option meta
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Meta
     */
    private $optionMeta;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Get $resource
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Get $resource,
        \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
    )
    {
        $this->resource = $resource;
        $this->optionFactory = $optionFactory;
        $this->optionMeta = $optionMeta;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Execute
     * 
     * @param array $skus
     * @param array|null $sourceCodes
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(array $skus, array $sourceCodes = null): array
    {
        if (empty($skus)) {
            throw new \Magento\Framework\Exception\InputException(__('No SKUs provided for the %1.', $this->optionMeta->getLabel()));
        }
        $optionsData = $this->resource->execute($skus, $sourceCodes);
        if (empty($optionsData)) {
            return [];
        }
        $options = [];
        foreach ($optionsData as $optionData) {
            if (isset($optionData['value']) && $optionData['value'] === null) {
                continue;
            }
            $option = $this->optionFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $option,
                $optionData,
                \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::class
            );
            $options[$option->getSku()][$option->getSourceCode()] = $option;
        }
        return $options;
    }
}