<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Observer\Inventory\Model\SourceItem\Option\Price;

/**
 * Process source item price options
 */
class Process extends \Ambros\InventoryCommon\Observer\Model\SourceItem\Option\Process
{
    /**
     * Constructor
     * 
     * @param \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType
     * @param \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface $isSingleSourceMode
     * @param \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Processor $optionsProcessor
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType,
        \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface $isSingleSourceMode,
        \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Processor $optionsProcessor,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig
    )
    {
        parent::__construct(
            $isSourceItemManagementAllowedForProductType,
            $isSingleSourceMode,
            $defaultSourceProvider,
            $optionsProcessor,
            $optionMeta,
            $optionConfig
        );
    }
}