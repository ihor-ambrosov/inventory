<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\Import\SourceItem\Option;

/**
 * Source item option convert
 */
class Convert
{
    /**
     * Option factory
     * 
     * @var \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory
     */
    private $optionFactory;

    /**
     * Source item option meta
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Meta
     */
    private $optionMeta;

    /**
     * Data object helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
    )
    {
        $this->optionFactory = $optionFactory;
        $this->optionMeta = $optionMeta;
        $this->dataObjectHelper = $dataObjectHelper;
    }
    
    /**
     * Convert
     * 
     * @param array $bunch
     * @return \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface[]
     */
    public function convert(array $bunch): array
    {
        $optionName = $this->optionMeta->getName();
        $options = [];
        foreach ($bunch as $optionData) {
            $optionData[\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::VALUE] = $optionData[$optionName] ?? null;
            $option = $this->optionFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $option,
                $optionData,
                \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::class
            );
            $options[] = $option;
        }
        return $options;
    }
}