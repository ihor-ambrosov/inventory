<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\SourceItem\Option;

/**
 * Source item options processor
 */
class Processor
{
    /**
     * Source item option factory
     * 
     * @var \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory
     */
    private $optionFactory;

    /**
     * Save source item options
     * 
     * @var \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface
     */
    private $saveOptions;

    /**
     * Delete source item options
     * 
     * @var \Ambros\InventoryCommon\Api\SourceItem\Option\DeleteInterface
     */
    private $deleteOptions;

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
     * @param \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface $saveOptions
     * @param \Ambros\InventoryCommon\Api\SourceItem\Option\DeleteInterface $deleteOptions
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory,
        \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface $saveOptions,
        \Ambros\InventoryCommon\Api\SourceItem\Option\DeleteInterface $deleteOptions,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
    )
    {
        $this->optionFactory = $optionFactory;
        $this->saveOptions = $saveOptions;
        $this->deleteOptions = $deleteOptions;
        $this->optionMeta = $optionMeta;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Execute
     * 
     * @param string $sku
     * @param array $optionsData
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    public function execute($sku, array $optionsData)
    {
        $options = [];
        foreach ($optionsData as $optionData) {
            $this->validateOptionData($optionData);
            $option = $this->optionFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $option,
                $this->prepareOptionData($sku, $optionData),
                \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::class
            );
            $options[] = $option;
        }
        if (empty($options)) {
            return $this;
        }
        $this->deleteOptions->execute($options);
        $this->saveOptions->execute($options);
        return $this;
    }

    /**
     * Validate option data
     * 
     * @param array $optionData
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    private function validateOptionData(array $optionData)
    {
        if (!isset($optionData[\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SOURCE_CODE])) {
            throw new \Magento\Framework\Exception\InputException(__('No source code provided for the %1.', $this->optionMeta->getLabel()));
        }
        return $this;
    }

    /**
     * Prepare option data
     * 
     * @param string $sku
     * @param array $optionData
     * @return array
     */
    private function prepareOptionData(string $sku, array $optionData): array
    {
        $optionName = $this->optionMeta->getName();
        $optionData[\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SKU] = $sku;
        $optionData[\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::VALUE] = $optionData[$optionName];
        if ($optionData[$optionName.'_use_default']) {
            unset($optionData[\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::VALUE]);
        }
        return $optionData;
    }
}